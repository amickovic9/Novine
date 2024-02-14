# Novine

Eketronske novine


## Instalacija

1. Klontirajte repozitorijum
   ```bash
   git clone https://github.com/amickovic9/Novine
2. Podignite Docker kontejner 
docker-compose up -d

3. Instaliranje zavisnosti 
composer install

3. Pokretanje migracije
php artisan migrate

# Konfiguracija
Laravel Konfiguracija (.env)
DB_CONNECTION: Postavljanje na mysql.
DB_HOST: Host MySQL baze podataka.
DB_PORT: Port MySQL baze podataka.
DB_DATABASE: Ime MySQL baze podataka.
DB_USERNAME: Korisničko ime za MySQL bazu podataka.
DB_PASSWORD: Lozinka za MySQL bazu podataka.

GitHub Actions je konfigurisan pomoću .github/workflows direktorijuma

Docker Konfiguracija
Docker konfiguracija je definisana u docker-compose.yml fajlu.

# Koriscenje
Pretraga vesti::
- po naslovu, tagovima, datumi i rublici
-lajkovanje i komentarisanje vesti
-citanje vesti
-dodavanje vesti, izmena

# Testiranje
News Search Test, Comments Test, News Tests

# GitHub Actions
Koriscen za CI

# Seeders
Seeders su dostupni za generisanje testnih podataka

# Doprinosi
Ako želite doprineti projektu, slobodno otvorite problem, predložite izmene ili doprinesite kodom. Sve sugestije su dobrodošle!