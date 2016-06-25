I had an idea to create an appserver for symfony, using RabbitMQ.

The application has 2 kernels, one for the app, one for the server.

web/appserver.php serves as a front contoller, pushing requests to rabbitmq.

The RPC result is a Response object.

**This was just for fun, i do not intend to continue working on this, but if you have an idea to improve it, I'd love to hear it :)**

#Some tests

-n 10000 -c 100 -l

|Mode|Failed requests|Requests per second|99%|
|---|---|---|---|
|Apache|0|187.76|730|
|rabbit-appserver - 1 consumer|0|281.20|407|
|rabbit-appserver - 2 consumers|0|**304.65**|**325**|

-n 10000 -c 250 -l

|Mode|Failed requests|Requests per second|99%|
|---|---|---|---|
|Apache|0|171.18|1997|
|rabbit-appserver - 1 consumer|0|**261.95**|**1031**|
