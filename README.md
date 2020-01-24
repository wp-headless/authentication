It is reccomended that the public/private key pair is provided via environment variables or constants. Due to the design of Wordpress plugins are unable to securly store files. This presents a security issue as the file system on some Wordpress installations is insecure. By default keypairs are generated and stored as files in the plugin directory.

## Configuration

The following can be set via environment variables or defining constants. Constants override env variables.

`OAUTH_PRIVATE_KEY`:

oAuth private key, if not provided keys will be generated.

Type: `string` 

Default: `null`

`OAUTH_PUBLIC_KEY`:

oAuth public key, if not provided keys will be generated.

Type: `string` 

Default: `null`

`OAUTH_ACCESS_TOKEN_EXPIRES`:

A valid PHP interval spec string that defines access token expiration, default is long lived 1 year tokens.

Type: `string`

Default: `P1Y`

`OAUTH_REFRESH_TOKEN_EXPIRES`:

A valid PHP interval spec string that defines refresh token expiration, default is long lived 1 year tokens.

Type: `string`

Default: `P1Y`