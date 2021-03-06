<!doctype html>
<html>
  <head>
    <title>SmsGlobal API</title>
    <style type="text/css">
      body {
      	font-family: Trebuchet MS, sans-serif;
      	font-size: 15px;
      	color: #444;
      	margin-right: 24px;
      }
      
      h1	{
      	font-size: 25px;
      }
      h2	{
      	font-size: 20px;
      }
      h3	{
      	font-size: 16px;
      	font-weight: bold;
      }
      hr	{
      	height: 1px;
      	border: 0;
      	color: #ddd;
      	background-color: #ddd;
      }
      
      .app-desc {
        clear: both;
        margin-left: 20px;
      }
      .param-name {
        width: 100%;
      }
      .license-info {
        margin-left: 20px;
      }
      
      .license-url {
        margin-left: 20px;
      }
      
      .model {
        margin: 0 0 0px 20px;
      }
      
      .method {
        margin-left: 20px;
      }
      
      .method-notes	{
      	margin: 10px 0 20px 0;
      	font-size: 90%;
      	color: #555;
      }
      
      pre {
        padding: 10px;
        margin-bottom: 2px;
      }
      
      .http-method {
       text-transform: uppercase;
      }
      
      pre.get {
        background-color: #0f6ab4;
      }
      
      pre.post {
        background-color: #10a54a;
      }
      
      pre.put {
        background-color: #c5862b;
      }
      
      pre.delete {
        background-color: #a41e22;
      }
      
      .huge	{
      	color: #fff;
      }
      
      pre.example {
        background-color: #f3f3f3;
        padding: 10px;
        border: 1px solid #ddd;
      }
      
      code {
        white-space: pre;
      }
      
      .nickname {
        font-weight: bold;
      }
      
      .method-path {
        font-size: 1.5em;
        background-color: #0f6ab4;
      }
      
      .up {
        float:right;
      }
      
      .parameter {
        width: 500px;
      }
      
      .param {
        width: 500px;
        padding: 10px 0 0 20px;
        font-weight: bold;
      }
      
      .param-desc {
        width: 700px;
        padding: 0 0 0 20px;
        color: #777;
      }
      
      .param-type {
        font-style: italic;
      }
      
      .param-enum-header {
      width: 700px;
      padding: 0 0 0 60px;
      color: #777;
      font-weight: bold;
      }
      
      .param-enum {
      width: 700px;
      padding: 0 0 0 80px;
      color: #777;
      font-style: italic;
      }
      
      .field-label {
        padding: 0;
        margin: 0;
        clear: both;
      }
      
      .field-items	{
      	padding: 0 0 15px 0;
      	margin-bottom: 15px;
      }
      
      .return-type {
        clear: both;
        padding-bottom: 10px;
      }
      
      .param-header {
        font-weight: bold;
      }
      
      .method-tags {
        text-align: right;
      }
      
      .method-tag {
        background: none repeat scroll 0% 0% #24A600;
        border-radius: 3px;
        padding: 2px 10px;
        margin: 2px;
        color: #FFF;
        display: inline-block;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
  <h1>SmsGlobal API</h1>
    <div class="app-desc">Swagger OpenApi description</div>
    <div class="app-desc">More information: <a href="https://helloreverb.com">https://helloreverb.com</a></div>
    <div class="app-desc">Contact Info: <a href="hello@helloreverb.com">hello@helloreverb.com</a></div>
    <div class="app-desc">Version: 0.1</div>
    <div class="app-desc">BasePath:/api</div>
    <div class="license-info">All rights reserved</div>
    <div class="license-url">http://apache.org/licenses/LICENSE-2.0.html</div>
  <h2>Access</h2>

  <h2><a name="__Methods">Methods</a></h2>
  [ Jump to <a href="#__Models">Models</a> ]

  <h3>Table of Contents </h3>
  <div class="method-summary"></div>
  <h4><a href="#Default">Default</a></h4>
  <ul>
  <li><a href="#3d6b8de56d220fdf6372e7d2e1a35716"><code><span class="http-method">post</span> /message</code></a></li>
  <li><a href="#d95013be656e7161b437df049644b9e2"><code><span class="http-method">get</span> /message</code></a></li>
  </ul>

  <h1><a name="Default">Default</a></h1>
  <div class="method"><a name="3d6b8de56d220fdf6372e7d2e1a35716"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /message</code></pre></div>
    <div class="method-summary"> (<span class="nickname">3d6b8de56d220fdf6372e7d2e1a35716</span>)</div>
    <div class="method-notes"></div>


    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#SendMessageRequest">SendMessageRequest</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    send an SMS to a user with success
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    handled error
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    authentication error
        <a href="#"></a>
    <h4 class="field-label">403</h4>
    authorization error
        <a href="#"></a>
    <h4 class="field-label">422</h4>
    validation error
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="d95013be656e7161b437df049644b9e2"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /message</code></pre></div>
    <div class="method-summary"> (<span class="nickname">d95013be656e7161b437df049644b9e2</span>)</div>
    <div class="method-notes"></div>





    <h3 class="field-label">Query parameters</h3>
    <div class="field-items">
      <div class="param">destination_number (required)</div>
      
            <div class="param-desc"><span class="param-type">Query Parameter</span> &mdash; destination number </div>    </div>  <!-- field-items -->



    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    list all the messages sent by a user with success
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    handled error
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    authentication error
        <a href="#"></a>
    <h4 class="field-label">403</h4>
    authorization error
        <a href="#"></a>
    <h4 class="field-label">422</h4>
    validation error
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>

  <h2><a name="__Models">Models</a></h2>
  [ Jump to <a href="#__Methods">Methods</a> ]

  <h3>Table of Contents</h3>
  <ol>
    <li><a href="#SendMessageRequest"><code>SendMessageRequest</code> - Send Message request</a></li>
  </ol>

  <div class="model">
    <h3><a name="SendMessageRequest"><code>SendMessageRequest</code> - Send Message request</a> <a class="up" href="#__Models">Up</a></h3>
    <div class='model-description'>Send Message request body data</div>
    <div class="field-items">
      <div class="param">destination_number </div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span> destination number </div>
          <div class="param-desc"><span class="param-type">example: +61000000000</span></div>
<div class="param">message </div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span> message </div>
          <div class="param-desc"><span class="param-type">example: This is an example message.</span></div>
    </div>  <!-- field-items -->
  </div>
  </body>
</html>
