# Pesistulokset

Tämän lisäosan avulla voit upottaa pesäpallon sarjataulukoita, otteluita tai tilastoja omille kotisivuillesi.

Lisäosan on kehittänyt Miika Salo.

## Käyttö

Lisäosan käyttö vaatii pesistulokset.fi:n rajapinta-avaimen. Syötä avain lisäosan asetuksiin.

Lisäosa tarjoaa pari eri tapaa lisätä sarjataulukoita sivuille:

### Sisältölohko

Lisäosa lisää Pesistulokset -lohkon, jota voi käyttää Gutenberg lohkoeditorissa. Lohkon asetuksista voi vaikuttaa samoihin asetuksiin kuin lyhytkoodissa.

### Lyhytkoodi

Sarjataulukon voi upottaa sivuille käyttämällä lyhytkoodia:

```php
[pesistulokset]
```

Lyhytkoodi hyväksyy seuraavat parametrit, joilla voi vaikuttaa mitä tilastoja näytetään:

```php
[pesistulokset season="2023"]
```
season -parametrilla valitaan minkä vuoden tilastot näytetään. Oletusarvo `2023`.

```php
[pesistulokset level="Superpesis"]
```
level -parametrilla valitaan minkä sarjat tilastot näytetään. Oletusarvo `Superpesis`. Hyväksyy arvot `Superpesis`, `Ykköspesis` tai `Suomensarja`

```php
[pesistulokset series="Miehet"]
```
series -parametrilla valitaan minkä tason tilastot näytetään. Oletusarvo `Miehet`. Hyväksyy arvot `Miehet`, `Naiset`, `Tytöt` tai `Pojat`

```php
[pesistulokset group="Runkosarja"]
```
group -parametrilla valitaan minkä lohkon tilastot näytetään. Oletusarvo `Runkosarja`. Kts. hyväksytyt arvot rajapintakuvauksesta osoitteessa https://ttk.pesistulokset.fi/api-docs

```php
[pesistulokset phase="Runkosarja"]
```
phase -parametrilla valitaan minkä sarjavaiheen tilastot näytetään. Oletusarvo `Runkosarja`. Kts. hyväksytyt arvot rajapintakuvauksesta osoitteessa https://ttk.pesistulokset.fi/api-docs

```php
[pesistulokset region="Runkosarja"]
```
region -parametrilla valitaan minkä alueen tilastot näytetään. Oletuksena tyhjä. Kts. hyväksytyt arvot rajapintakuvauksesta osoitteessa https://ttk.pesistulokset.fi/api-docs

```php
[pesistulokset highlight="SoJy"]
```
highlight -parametrilla voi korostaan yhden joukkueen riviä taulukossa. Arvona joukkueen lyhenne.

```php
[pesistulokset columns="o,v,t,h,3p,2p,1p,0,j,p,ppg"]
```
columns -parametrilla voi näyttää tai piilottaa taulukon sarakkeita. Erottele sarakkeet pilkulla. Oletusarvo `o,v,t,h,3p,2p,1p,0,j,p`

```php
[pesistulokset show_header="true"]
```
show_header -parametrilla voi näyttää tai piilottaa taulukon otsakkeen. Oletusarvo `true`

#### Esimerkki

```php
[pesistulokset season="2022" level="Superpesis" series="Naiset"]
```
Tämä lyhytkoodi näyttää Naisten Superpesiksen sarjataulukon vuodelta 2022.

### Vimpain

Lisäosa rekisteröi Pesistulokset -vimpaimen, jolla sarjataulukon voi upottaa mihin tahansa teeman vimpainalueeseen. Vimpaimen asetuksista voi määrittää samat asetukset kuin lyhytkoodissa.

## Disclaimer

Huom! Tämä on epävirallinen lisäosa. Lisäosa hyödyntää pesistulokset.fi -rajapintaa. Pesistulokset.fi ei sponsoroi, suosittele, kehitä tai hallinnoi tätä lisäosaa.

## Lisenssi

[GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.txt)