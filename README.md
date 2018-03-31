# Galactic Trade War
  
  Start it up via Docker:
  
  ```$ docker build . -t gtw
  $ docker run -d -p 2222:2222 gtw <parameters>
  ``` 
  Where <parameters> can include the following:
  * -port (default 2222)
  * -host [mongoHost]:[mongoPort] 
  * -user [mongoUser]
  * -pass [mongoPassword] 
  * -db [mongoDatabase]
 
  Connect to it via ssh! 
