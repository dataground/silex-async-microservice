# Silex asynchronous microservice skeleton

Silex based asynchronous microservice skeleton with testing tools, RabbitMQ server connection capabilities and HTTP client to send callbacks.

A running [RabbitMQ server](https://www.rabbitmq.com/download.html) is required to manage asynchronous messages.

- [Silex 1.3](http://silex.sensiolabs.org/)
- [Symfony Console 2.8](https://packagist.org/packages/symfony/console)
- [Symfony Monolog Bridge 3.0](https://packagist.org/packages/symfony/monolog-bridge)
- [PHPAMQPLib 2.6](https://packagist.org/packages/php-amqplib/php-amqplib)
- [Guzzle HTTP Client 6.1](https://packagist.org/packages/guzzlehttp/guzzle)
- [Behat 3.0 + Mink Extension 2.2 + Goutte Driver 1.2](http://docs.behat.org/en/v3.0/)
- [PHPSpec 2.4](http://www.phpspec.net/en/latest/manual/introduction.html)
- [PHPUnit 5.2](https://phpunit.de/documentation.html)

The global picture:

1. **Controller** Receive an HTTP request with an operation id, parameters and a callback URL. Response 'Working on it'.
2. **Manager** Construct the operation.
3. **Producer** Send a message with the operation to the RabbitMQ server queue.
4. **Consumer/s** Consume the message from the RabbitMQ server queue.
5. **Manager** Process the operation and send an HTTP request to the callback URL with the operation result.

Consumers are running processes that keep listening to the queue messages.  
A console command ```bin/console app:consumer``` is provided to launch consumers and delegate the operation process logic to the manager but a [really simple script](https://github.com/rabbitmq/rabbitmq-tutorials/blob/master/php/receive.php) is all that is needed to launch a consumer. If your consumers are external to the app, you may put the operation process logic in them.

## Structure

```bash
bin/       <- Executables (console, behat, ...)
config/    <- Environment configurations
features/  <- Behat features
spec/      <- PHPSpec specs
src/       <- Code, default namespace
tests/     <- PHPUnit tests
var/
    cache/
    logs/
web/       <- App entry points
```

## Getting started

1. ```composer install ```
2. Edit the config files and configure the RabbitMQ server parameters.
3. Point your virtual host to the ```web/``` folder.
4. Edit ```behat.yml.dist``` and replace the ```base_url``` value with your virtual host.

## Testing

A simple example is provided for each testing tool:

- Behat: ```features/example.feature```
- PHPSpec: ```spec/ExampleSpec.php```
- PHPUnit: ```tests/ExampleTest.php```

Run them with:

```bash
bin/behat --format pretty
bin/phpspec run --format pretty
bin/phpunit
```

## License

This code is distributed under the MIT license: [LICENSE](LICENSE).
