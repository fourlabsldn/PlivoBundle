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

## Suggested Implementation

Create a Doctrine entity that extends \Plivo\Model\SmsIncoming
Create a Doctrine entity that extends \Plivo\Model\SmsOutgoing
Create EventListeners that will persist sms messages to the database, for example:

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



## License

PlivoBundle is licensed under the MIT license.

