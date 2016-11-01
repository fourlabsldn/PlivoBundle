# PlivoBundle

## Installation


Install with composer
```bash
    $ composer require fourlabs/plivo-bundle
```

Add the bundle to app/AppKernel.php
```php
<?php
    //...
    $bundles = [
        // ...
        // FLPlivoBundle depends on GuzzleBundle
        // Add it if it's not already present in your $bundles
        new EightPoints\Bundle\GuzzleBundle\GuzzleBundle(), 
        new FL\PlivoBundle\FLPlivoBundle(),    
    ];
            
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
  development_mode: true # if set to true, sms will not be sent - defaults to false
```

## Sample Routing

```yaml
// app/config/routing.yml
fl_plivo:
    resource: "@FLPlivoBundle/Resources/config/routing.yml"
    prefix:   /
```

## Suggested Implementation

- Create a Doctrine entity that extends \Plivo\Model\SmsIncoming
- Create a Doctrine entity that extends \Plivo\Model\SmsOutgoing
- Create EventListeners that will persist sms messages to the database, for example:

```yaml
  app.message_delivery_report_listener:
    class: AppBundle\EventListener\MessageDeliveryReportListener
    arguments:
      - '@doctrine.orm.entity_manager'
      - "@=service('doctrine').getRepository('AppBundle:SmsOutgoing')"
    tags:
      - { name: kernel.event_listener, event: fl_plivo.outgoing_sms.delivered, method: onMessageDeliveryReport }

  app.message_sent_listener:
    class: AppBundle\EventListener\MessageSentListener
    arguments:
      - '@doctrine.orm.entity_manager'
    tags:
      - { name: kernel.event_listener, event: fl_plivo.outgoing_sms.sent, method: onMessageSent }

  app.message_received_listener:
    class: AppBundle\EventListener\MessageReceivedListener
    arguments:
      - '@doctrine.orm.entity_manager'
      - "@=service('doctrine').getRepository('AppBundle:SmsOutgoing')"
    tags:
      - { name: kernel.event_listener, event: fl_plivo.incoming_sms.received, method: onMessageReceived }
```

- To receive SMS messages, follow the instructions for https://www.plivo.com/faq/sms/how-can-i-receive-sms-messages-with-my-plivo-numbers/ 
- Use the corresponding url for the route `fl_plivo.post_message`

## License

PlivoBundle is licensed under the MIT license.

