FROM rabbitmq:3.13.6-management

COPY ./_docker/rabbitmq/rabbitmq_delayed_message_exchange-3.13.0.ez /plugins/rabbitmq_delayed_message_exchange-3.13.0.ez

RUN rabbitmq-plugins enable rabbitmq_delayed_message_exchange