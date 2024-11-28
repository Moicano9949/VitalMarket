import time
import sys

while True:
	message = 'starting the metasploit framework...'
	for x in range(len(message)):
		sys.stdout.write('\r'+'[*] '+message[:x]+message[x:].capitalize())
		sys.stdout.flush()
		time.sleep(0.1)
