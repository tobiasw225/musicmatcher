import subprocess
from subprocess import Popen, PIPE
import os
#if not os.environ.has_key("HOME"):
#    print("there's no home for you here.")
#else:

#os.environ['HOME'] = '/home/docker'

print(os.environ.keys())    
    
AUDIVERIS_PATH = "/home/docker/Audiveris/bin/Audiveris"

session =subprocess.Popen([AUDIVERIS_PATH,\
                            "-batch -print -export -output ../out ../out/bub_gb_1UMvAAAAMAAJ_Page_0x131df.png"],
                          stdout=PIPE, stderr=PIPE)

stdout, stderr = session.communicate()



if session.returncode == 0: 
    text = session.communicate()[0]
    print(len(text))
else:
    print(stderr.decode("utf-8"))

