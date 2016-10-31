# PlivoBundle

## Installation

```bash
    $ composer require fourlabs/plivo-bundle
```

## Sample Configuration

```yaml
# Guzzle Configuration
guzzle:
    clients:
        plivo: # configure plivo client
            base_url: 'https://api.plivo.com/v1/Account/%plivo_auth_id%/'
            headers:
                Accept: "application/json"
            options:
                auth:
                    - %plivo_auth_id% # user
                    - %plivo_auth_token% # password
                timeout: 30

# Plivo Configuration
fl_plivo:
  sms_incoming_class: AppBundle\Entity\SmsIncoming
  sms_outgoing_class: AppBundle\Entity\SmsOutgoing
```

## Sample Routing

```yaml
// app/config/routing.yml
fl_plivo:
    resource: "@FLPlivoBundle/Resources/config/routing.yml"
    prefix:   /
```

## License

PlivoBundle is licensed under the MIT license.

