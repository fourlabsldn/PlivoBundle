# PlivoBundle

[![StyleCI](https://styleci.io/repos/72456491/shield?branch=master)](https://styleci.io/repos/72456491)
[![Total Downloads](https://poser.pugx.org/fourlabs/plivo-bundle/downloads)](https://packagist.org/packages/fourlabs/plivo-bundle)
[![License](https://poser.pugx.org/fourlabs/plivo-bundle/license)](https://packagist.org/packages/fourlabs/plivo-bundle)

## Installation

Install with composer
```bash
    $ composer require fourlabs/plivo-bundle eightpoints/guzzle-bundle
```

Add these bundles to app/AppKernel.php
```php
<?php
    //...
    $bundles = [
        // ...
        // FLPlivoBundle depends on GuzzleBundle and MisdPhoneNumberBundle
        // Add them if they're not already present in your $bundles
        new EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle(), 
        new Misd\PhoneNumberBundle\MisdPhoneNumberBundle(), 
        new FL\PlivoBundle\FLPlivoBundle(),    
    ];
            
```

## Sample Configuration

```yaml
# Guzzle Configuration
eight_points_guzzle:
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
  development_mode: true # if set to true, sms will not be sent - defaults to false
```

## Sample Routing

```yaml
# app/config/routing.yml
fl_plivo:
    resource: "@FLPlivoBundle/Resources/config/routing.yml"
    prefix:   /
```

## Suggested Implementation

- Create an entity for your ORM/ODM (e.g. Doctrine) that extends \Plivo\Model\SmsIncoming
- Create an entity that extends \Plivo\Model\SmsOutgoing
- If you are using Doctrine, you can use the corresponding event listeners, by importing them. 
```yaml
# app/config/config.yml
imports:
    - { resource: "@FLPlivoBundle/Resources/config/event-listener/doctrine.yml"}
```
- If you are using not using Doctrine, create your own event listeners and submit a pull request ;)
- To receive SMS messages, follow the instructions from [Plivo](https://www.plivo.com/faq/sms/how-can-i-receive-sms-messages-with-my-plivo-numbers/) 
- Use the corresponding url for the route `fl_plivo.post_message` (If you imported the default routing file, without a prefix, this would be /api/v1.0/message)

## License

PlivoBundle is licensed under the MIT license.
