#!/bin/bash

# enable debugging if --debug arg is used
if [ "$1" == "--debug" ]; then
  OUTPUTDEVICE="/dev/stdout"
else
  OUTPUTDEVICE="/dev/null"
fi

# User must be logged in as root 
if [ $(whoami) != "root" ]; then
  echo "You must log in as root to run this script."
  exit 1
fi

# Default Mapping Location
MAP_LOCATION=${HOME}/

# Connection info
SERVER="151.155.148.76"
CONTEXT="novell"
USER="admin"
PASSWORD="novell"

# Colors
NORMAL="[0;39m"
RED="[1;31m" # failure
GREEN="[1;32m" # success

# Function for printing whether each step was successful or not
print_status()
{
  if [ $1 -eq 0 ]; then
    echo "${GREEN}Success!${NORMAL}"
  else
    echo "${RED}Failure!"
    echo -e "${2} Debug this script or run the test cases manually.${NORMAL}"
    exit 1
  fi
}

# Log into server
echo -n "Logging into $SERVER..."
nwlogin -s $SERVER -c $CONTEXT -u $USER -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while connecting to server."

# Create mapping
echo -n "Mapping drive..."
nwmap -s $SERVER -d tempmap -v V0 &> $OUTPUTDEVICE
print_status $? "An error occured while mapping drive."

# Move to home directory
cd

# Obtain mapping location if something other than the default and assign to MAP_LOCATION variable
echo -n "Obtaining default mapping location..."
if [[ -e /etc/opt/novell/ncl/map.conf ]]; then
  MAP_LOCATION=`awk -F= '/Map_Link_Default_Location/ {print $2}' /etc/opt/novell/ncl/map.conf`
fi
print_status $? "An error occured while obtaining default mapping location."

# Function to clean up files on exit or crash
remove_temp_files()
{
  rm -f ${MAP_LOCATION}/tempmap/bintar.tar.gz # from datetime preservation tc
  rm -rf ${MAP_LOCATION}/tempmap/bin/ # from datetime preservation tc
  rm -f ${MAP_LOCATION}/tempmap/links.tar.gz # from project compile tc
  rm -rf ${MAP_LOCATION}/tempmap/links-2.1pre21/ # from project compile tc
  rm -rf ${MAP_LOCATION}/tempmap/deepdir1/ # from deep directory tc
  echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE
}
trap remove_temp_files 0 1 2 3 9 10 11 13 # exit codes that will be caught

#####################################################################################################
## BOUNDARY TEST CASE                                                                              ##
## Uses nwlogin to verify that it accepts the following credential variations:                     ##
##                                                                                                 ##
## .username                                                                                       ##
## .cn=username                                                                                    ##
## cn=username                                                                                     ##
## .cn=username.o=context                                                                          ##
## cn=username.o=context                                                                           ##
## .username.context                                                                               ##
## username.context                                                                                ##
#####################################################################################################

echo -n "Would you like to run the boundary test case? (Y or N) "
read 
while [[ $REPLY != [YyNn] ]]; do
  echo "Invalid response."
  echo -n "Would you like to run the boundary test case? (Y or N) "
  read
done

if [[ $REPLY = [Yy] ]]; then

echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with .username..."
nwlogin -s $SERVER -c $CONTEXT -u .$USER -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with .username"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with .cn=username..."
nwlogin -s $SERVER -c $CONTEXT -u .cn=$USER -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with .cn=username"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with cn=username..."
nwlogin -s $SERVER -c $CONTEXT -u cn=$USER -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with cn=username"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with .cn=username.o=context..."
nwlogin -s $SERVER -u .cn=$USER.o=$CONTEXT -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with .cn=username.o=context"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with cn=username.o=context..."
nwlogin -s $SERVER -u cn=$USER.o=$CONTEXT -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with cn=username.o=context"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with .username.context..."
nwlogin -s $SERVER -u .$USER.$CONTEXT -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with .username.context"
echo y | nwlogout -s $SERVER &> $OUTPUTDEVICE

echo -n "Testing with username.context..."
nwlogin -s $SERVER -u $USER.$CONTEXT -p $PASSWORD &> $OUTPUTDEVICE
print_status $? "An error occured while testing with username.context"
# No logging out here--leave connection open

# Create mapping to resemble previous state
nwmap -s $SERVER -d tempmap -v V0 &> $OUTPUTDEVICE

fi

#####################################################################################################
## DATETIME PRESERVATION TEST CASE                                                                 ##
## Creates gzipped tar from /bin folder, copies the .tar.gz to the server, untars and gunzips it.  ##
## Then compares the orginal datetime for the "touch" command with the copied "touch" command.     ##
## If they are the same, the test case passes.  If not, it fails.                                  ##
#####################################################################################################

# Prompts whether or not the user would like to run this test case
echo -n "Would you like to run the datetime preservation test case? (Y or N) "
read 
while [[ $REPLY != [YyNn] ]]; do
  echo "Invalid response."
  echo -n "Would you like to run the datetime preservation test case? (Y or N) "
  read
done

if [[ $REPLY = [Yy] ]]; then

echo -n "Tarring and gzipping bin folder..."
tar -czf bintar.tar.gz /bin &> $OUTPUTDEVICE
print_status $? "An error occured while tarring and gzipping bin folder."

echo -n "Moving bintar.tar.gz to server..."
mv bintar.tar.gz ${MAP_LOCATION}/tempmap/bintar.tar.gz &> $OUTPUTDEVICE
print_status $? "An error occured while moving bintar.tar.gz to server."

cd ${MAP_LOCATION}/tempmap/

echo -n "Untarring and gunzipping bintar.tar.gz..."
tar -xzf bintar.tar.gz &> $OUTPUTDEVICE
print_status 0 "An error occured while untarring and gunzipping bintar.tar.gz."

echo -n "Comparing datetimes of original bin contents with copied bin contents..."
ORIGINAL_DATETIME=`ls -l /bin | grep touch | tr -s ' ' | cut -d ' ' -f6-7`
COPIED_DATETIME=`ls -l ${MAP_LOCATION}/tempmap/bin | grep touch | tr -s ' ' | cut -d ' ' -f6-7`
if [[ "$ORIGINAL_DATETIME" = "$COPIED_DATETIME" ]]; then
  EXIT_STATUS=0
else
  EXIT_STATUS=1
fi
print_status $EXIT_STATUS "An error occured while comparing datetimes of original bin contents with copied bin contents. The test case may have failed or there may have been a script error."

echo "${GREEN}Congrats! Datetime preservation test case ran successfully!${NORMAL}"

cd

fi

#####################################################################################################
## PROJECT COMPILE TEST CASE                                                                       ##
## Downloads the program Links.  Copies Links to server, gunzips it, untars it, configures it,     ##
## makes it, installs it, then verifies installation.  If /usr/local/bin/links exists after        ##
## installation, it's assumed the project installed successfully.  If it installed successfully,   ##
## the test case passes.  Otherwise, it fails.                                                     ##
#####################################################################################################

# Prompts whether or not the user would like to run this test case
echo -n "Would you like to run the project compile test case? (Y or N) "
read 
while [[ $REPLY != [YyNn] ]]; do
  echo "Invalid response."
  echo -n "Would you like to run the project compile test case? (Y or N) "
  read
done

if [[ $REPLY = [Yy] ]]; then

echo -n "Downloading Links..."
wget http://151.155.148.76/links.tar.gz &> $OUTPUTDEVICE
print_status $? "An error occured while downloading Links."

echo -n "Copying Links to server..."
mv links.tar.gz ${MAP_LOCATION}/tempmap/links.tar.gz &> $OUTPUTDEVICE
print_status $? "An error occured while moving Links to server."

cd ${MAP_LOCATION}/tempmap/

echo -n "Untarring Links..."
tar -zxvf ${MAP_LOCATION}/tempmap/links.tar.gz &> $OUTPUTDEVICE
print_status $? "An error occured while untarring Links."

cd ${MAP_LOCATION}/tempmap/links-2.1pre21

echo -n "Configuring Links..."
./configure &> $OUTPUTDEVICE
print_status $? "An error occured while untarring Links."

echo -n "Making Links..."
make &> $OUTPUTDEVICE
print_status $? "An error occured while making Links."

echo -n "Installing Links..."
make install &> $OUTPUTDEVICE
print_status $? "An error occured while installing Links."

echo -n "Verifying Links installation..."
if [[ -e /usr/local/bin/links ]]; then
  EXIT_STATUS=0
else
  EXIT_STATUS=1
fi
print_status $EXIT_STATUS "An error occured while verifying Links installation."

echo "${GREEN}Congrats! Project compile test case ran successfully!${NORMAL}"

fi

#####################################################################################################
## DEEP DIRECTORY TEST CASE                                                                        ##
## Creates deep directory on server (20 directories deep).  In deep directory, a file is created,  ##
## renamed, and copied. If all goes well, test case is successful.  If not, it fails.              ##
#####################################################################################################

# Prompts whether or not the user would like to run this test case
echo -n "Would you like to run the deep directory test case? (Y or N) "
read 
while [[ $REPLY != [YyNn] ]]; do
  echo "Invalid response."
  echo -n "Would you like to run the deep directory test case? (Y or N) "
  read
done

if [[ $REPLY = [Yy] ]]; then

echo -n "Creating deep directory..."
mkdir -p ${MAP_LOCATION}/tempmap/deepdir1/deepdir2/deepdir3/deepdir4/deepdir5/deepdir6/deepdir7/deepdir8/deepdir9/deepdir10/deepdir11/deepdir12/deepdir13/deepdir14/deepdir15/deepdir16/deepdir17/deepdir18/deepdir19/deepdir20/ &> $OUTPUTDEVICE
print_status $? "An error occured while creating deep directory."

echo -n "Creating file in deep directory..."
touch ${MAP_LOCATION}/tempmap/deepdir1/deepdir2/deepdir3/deepdir4/deepdir5/deepdir6/deepdir7/deepdir8/deepdir9/deepdir10/deepdir11/deepdir12/deepdir13/deepdir14/deepdir15/deepdir16/deepdir17/deepdir18/deepdir19/deepdir20/deepfile.txt &> $OUTPUTDEVICE
print_status $? "An error occured while creating file in deep directory."

echo -n "Renaming file in deep directory..."
mv ${MAP_LOCATION}/tempmap/deepdir1/deepdir2/deepdir3/deepdir4/deepdir5/deepdir6/deepdir7/deepdir8/deepdir9/deepdir10/deepdir11/deepdir12/deepdir13/deepdir14/deepdir15/deepdir16/deepdir17/deepdir18/deepdir19/deepdir20/deepfile.txt ${MAP_LOCATION}/tempmap/deepdir1/deepdir2/deepdir3/deepdir4/deepdir5/deepdir6/deepdir7/deepdir8/deepdir9/deepdir10/deepdir11/deepdir12/deepdir13/deepdir14/deepdir15/deepdir16/deepdir17/deepdir18/deepdir19/deepdir20/deepfile_renamed.txt &> $OUTPUTDEVICE
print_status $? "An error occured while renaming file in deep directory."

echo -n "Copying file to deep directory..."
cp /bin/touch ${MAP_LOCATION}/tempmap/deepdir1/deepdir2/deepdir3/deepdir4/deepdir5/deepdir6/deepdir7/deepdir8/deepdir9/deepdir10/deepdir11/deepdir12/deepdir13/deepdir14/deepdir15/deepdir16/deepdir17/deepdir18/deepdir19/deepdir20/touchfile_copied &> $OUTPUTDEVICE
print_status $? "An error occured while copying file to deep directory."

echo "${GREEN}Congrats! Deep directory test case ran successfully!${NORMAL}"

fi

#####################################################################################################
## LARGE FILE TEST CASE                                                                            ##
## Copies 400 MB large file from /dev/zero to server.  If it copies fine, the test case passes.    ##
## Otherwise, it fails.                                                                            ##
#####################################################################################################

# Prompts whether or not the user would like to run this test case
echo -n "Would you like to run the large file test case? (Y or N) "
read 
while [[ $REPLY != [YyNn] ]]; do
  echo "Invalid response."
  echo -n "Would you like to run the large file test case? (Y or N) "
  read
done

if [[ $REPLY = [Yy] ]]; then

echo -n "Copying large file to deep directory..."
dd if=/dev/zero of=${MAP_LOCATION}/tempmap/large_copied_file.txt bs=1M count=400 &> $OUTPUTDEVICE
print_status $? "An error occured while copying large file to deep directory."

echo "${GREEN}Congrats! Large file test case ran successfully!${NORMAL}"

fi
