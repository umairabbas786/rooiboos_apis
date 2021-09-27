#!/usr/bin/env python3

import os

ROOIBOOSROOT = "rooiboosapi"
os.system('rm SERVER.tar.gz')

if not os.path.exists('build'):
    os.mkdir('build')

ignore = ['.idea', '.gitignore', 'data', '.git', 'compile.py', 'build', 'composer.json', 'composer.lock']

for f in os.listdir():
    if f not in ignore:
        os.system(f'cp -rf {f} build/')

db_file_content = []

with open('build/app/database/db/Cab5DB.php', 'r') as db_file:
    for lin in db_file.readlines():
        db_file_content.append(lin)

# on Cab5 hosting
DB_USERNAME = "cab5_c5suBhola"
DB_PASSWORD = "uy0UsGcpJrxL"
DATABASE = "cab5_electro"

# on My Namecheap
# DB_USERNAME = "numbvscc_cab5"
# DB_PASSWORD = "smstoconnect???"
# DATABASE = "numbvscc_cab5"

with open('build/app/database/db/Cab5DB.php', 'w+') as db_file:
    for lin in db_file_content:
        if 'const USERNAME = ' in lin:
            lin = lin.replace('\"root\"', f'\"{DB_USERNAME}\"')
        elif 'const PASSWORD = ' in lin:
            lin = lin.replace('\"\"', f'\"{DB_PASSWORD}\"')
        elif 'const DATABASE = ' in lin:
            lin = lin.replace('\"cab5\"', f'\"{DATABASE}\"')
        db_file.write(lin)

os.system('rm build/app/libs/query_builder/QueryBuilderUsage.txt')
os.system('rm build/app/utils/image_uploader/ImageUploaderUsage.txt')

def getRouteName(agent):
    route = ""
    for i in range(len(agent)):
        if agent[i].isupper() and i > 0:
            route = route + '_{}'.format(agent[i])
        else:
            route = route + agent[i]
    return route.lower()

routes = []
for f in os.listdir("app/agents"):
    routeName = getRouteName(f)
    with open(f'build/{routeName}', 'w+') as routeFile:
        routeFile.write('<?php require "app/Manifest.php";\n')
        routeFile.write('(new {}())->launch();'.format(f[:-4]))
    routes.append(routeName)

print("Creating TarBall... ")
os.system('cd build && tar -czf ../SERVER.tar.gz * && cd .. && rm -rf build')

print("Connecting To Ftp Client")
#os.system('ftp cab5.pk')

print("Launching SSH Session")
#os.system('ssh cab5@cab5.pk')
