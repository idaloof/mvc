# GITHUB-repo för MVC-kursen

[![Build Status](https://scrutinizer-ci.com/g/idaloof/mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/idaloof/mvc/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/idaloof/mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/idaloof/mvc/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/idaloof/mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/idaloof/mvc/?branch=main)

Det här repot är en symfony-applikation som innehåller:

* Två kortspel: black jack och texas hold'em
* Ett biblioteksapp med möjligheten att lägga till och ta bort böcker
* API-endpoints för kortlek, biblioteket och spel

Symfony är ett php-ramverk som underlättar för användare att bygga applikationer. Med Symfony
får användaren en färdig struktur att bygga i samt möjligheten att på ett enkelt sätt koppla
applikationen till valfria databashanterare.

MVC
----

MVC står för Model View Controller, vilket är ett designmönster. Med detta mönster tillåts användaren att arbeta på ett objektorienterat sätt, där olika delar av applikationen har ett tydligt ansvar.

Skapade klasser agerar som modeller med logik som appens controllers använder för att skapa och hämta data med,
som i sin tur renderas i olika templates (views).

Kodanalys
---------

I kursen har vi även arbetat med olika linters och mätvärden för snygg och testbar kod. Läs mer om detta under
sidan Metrics. Scrutinizer och PHPMetrics är exempel på verktyg som går att använda för att analysera kod.

Bygg applikationen
------------------

För att bygga applikationen behöver du följande:

<strong>Kontrollera att du har PHP i din path:</strong>

<code>$ php --version</code>

Om du inte har rätt version (lägre än 8), kan du lägga till PHP 8 i pathen:

https://dbwebb.se/kunskap/lagg-php8-i-pathen

<strong>Kontrollera att du har composer (pakethanterare för PHP):</strong>

<code>$ composer --version</code>

Annars installerar du composer:

https://getcomposer.org/

<strong>Klona repot med:</strong>

<code>$ git clone git@github.com:idaloof/mvc.git</code>

<strong>Fyll på texas-databasen:</strong>

Installera League Csv:
<code>$ composer require league/csv:^9.0</code>

Kör kommandot csv:import:
<code>$ php bin/console csv:import</code>

Koppla ditt repo till scrutinizer
---------------------------------

https://github.com/dbwebb-se/mvc/tree/main/example/scrutinizer

Kör igång appen
---------------
<code>$ php -S localhost:8888 -t public</code>
