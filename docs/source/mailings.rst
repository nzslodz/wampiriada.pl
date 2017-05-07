=====================
Maile i ich wysyłanie
=====================

Ta strona pokazuje, w jaki sposób stworzyć powiadomienia w aplikacji.

.. note:: Ta implementacja rozsyłania maili została stworzona zanim Laravel 5.3 wprowadził `Mail Notifications <https://laravel.com/docs/5.4/notifications>`_ , dlatego część tej implementacji pokrywa się z rozwiązaniami, które zostały wprowadzone w nowszych wydaniach Laravela. Na przyszłość, na tyle, na ile to możliwe, planowane jest połączenie obu tych rozwiązań, aby uczynić sekcję powiadomień prostszą w nauce i bardziej intuicyjną dla osób, które znają framework.

Tworzenie wysyłalnego e-maila
=============================

Aby móc skorzystać z rozsyłania e-maili, należy przygotować klasę Mailing Composera. Ta klasa odpowiada za przygotowywanie treści e-maila dla danej osoby.

1. Klasa Mailing Composer
-------------------------

Composer jest bazową klasą dla mailingów. Poniżej znajduje się przykładowa klasa composera.

.. literalinclude:: ../../wampiriada-lib/src/Mailing/WampiriadaReminderMailingComposer.php
   :language: php
