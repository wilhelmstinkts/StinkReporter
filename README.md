# StinkReporter
The Stink Reporter provides a RESTful HTTP-api to report when and where it stinks and query for past stinks.
The use can be looked up in the [OpenApi Specification](interface/openapi.yaml)

## Environment settings
We use a file that contains environment settings: [env.php](source/env.php)
The checked in version obviously only contains test settings and will not be copied to the server.
Please upload a production env.php manually.
