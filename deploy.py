import paramiko
import os

# ssh config
# Ubuntu Server 18.04 vCPU 2 & RAM 4GB
hostname = '111.11.111.111';
username = 'root'; # 
password = 'password'; # pass

# additional variables
alias = 'web';
target_dir = '/var/www/jenkins-log/'+alias+'/'; # directory in staging
ignore_file_and_dir = [".DS_Store", "deploy.py", ".gitignore", ".prettierrc", ".eslintrc.js", ".git", "composer.lock", "vendor"];
# define class for transferring file and generate sub directory
class SFTPClient(paramiko.SFTPClient):
    def put_dir(self, source_dir, target_dir, sub_dir = ''):
        ''' mapping file inside directory '''
        for file in os.listdir(source_dir):
            isMatch = file in ignore_file_and_dir;

            if isMatch == False:
                source_file = os.path.join(source_dir, file);
                target_file = file;

                if sub_dir:
                    target_file = sub_dir+'/'+file;
                
                # generate sub directory and transferring file inside it
                if os.path.isdir(source_file):
                    print(target_file);
                    self.mkdir(os.path.join(target_dir, target_file));
                    self.put_dir(source_file, target_dir, target_file);
                else:
                    # transferring root file
                    print(target_file);
                    self.put(source_file, os.path.join(target_dir, target_file));



# open transport and SFTP connection
transport = paramiko.Transport((hostname));
transport.connect(username=username, password=password);
ftp_client = SFTPClient.from_transport(transport);

# auto pilot deploy
session = transport.open_channel(kind='session');
# clear remote directory
session.exec_command('rm -rf ' + target_dir);
session.close();
ftp_client.mkdir(target_dir);

# call transferring function
ftp_client.put_dir("/Users/me/Documents/work/jenkins-logs", target_dir); # transfer local_dir to staging_dir

# exit connection
ftp_client.close();
transport.close();

# open ssh connection
ssh = paramiko.SSHClient()
ssh.load_system_host_keys()
ssh.connect(hostname, username=username, password=password)
print('>>>>>>>>>>>>>>>>>>>>>');
print('installing.. package');
commandstring = "cd "+target_dir + ' ; ' + 'sudo composer install';
si,so,se = ssh.exec_command(commandstring) 
readList = so.readlines()
errList = se.readlines()
print(readList)
print(errList)
print('success deploy');
ssh.close();
