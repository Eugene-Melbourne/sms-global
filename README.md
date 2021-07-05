## Powered by  

- <a href="https://laravel.com" target="_blank"> Laravel Framework v7.30.4 </a>
- <a href="https://smsglobal.com" target="_blank"> SMSGlobal </a>

## About API

API endpoints ask a user to provide their API Keys that they have generated on SMSGlobal for their own accounts.

### To send an SMS for a user.
- method: **POST**
- end point: **/api/message**
- body Json example: **{"destination_number":"+61000000000","message":"This is an example message."}** (please replace the example data with real values)
- authentication: "Basic Auth"
- status: functional

### To list all the messages sent by the user.
- method: **GET**
- end point: **/api/message**
- body Json example: **{"destination_number":"+61000000000"}** (please replace the example data with real values)
- authentication: "Basic Auth"
- status: not functional

### API Specification

#### Request Headers
- "Content-Type" : "application/json"
- "Accept" : "application/json"
- "Host" : {calculated when request is sent}
- "Content-Length" : {calculated when request is sent}

#### Request Authorization
- Type : "Basic Auth"
- Username "take your REST API Key from <a href="https://smsglobal.com" target="_blank"> SMSGlobal </a>"
- Password "take your REST API Secret from <a href="https://smsglobal.com" target="_blank"> SMSGlobal </a>"

## To display a <a href="https://swagger.io/" target="_blank"> Swagger </a> OpenAPI documentation of the `/api` endpoints. 
- method: **GET**
- end point: **/docs**
- authentication: "no"
- status: under consturction
