<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OriginalDataSeeder extends Seeder
{
    /**
     * Spustí import dát z pôvodného SQL súboru.
     * php artisan db:seed --class=OriginalDataSeeder
     * @return void
     */
    public function run()
    {
        // Pôvodné slovenské názvy tabuliek v SQL súbore (sú v úvodzovkách).
        // Dôležité: Tieto mapovania budú použité iba na preklad názvu tabuľky v príkaze INSERT INTO.
        $originalTables = [
            'chovatel' => 'breeders',
            // Prekladá sa ako breeder_users, nie queen_breeders, aby to lepšie sedelo s logikou autentifikácie.
            'chovatel_matiek' => 'queen_breeders',
            'chovatel_m_rok' => 'queen_breeder_years',
            // Podľa migrácie by to malo byť 'evaluations'
            'hodnotenie' => 'ratings',
            'inseminator' => 'inseminators',
            'linia' => 'lines',
            'matka' => 'queens',
            'obce' => 'villages',
            'objednavky' => 'orders',
            'opravnenie' => 'authorizations',
            'plemenna_matka' => 'pedigree_queens',
            'pocet_prihlaseni' => 'login_attempts',
            'seria' => 'series',
            'ulice' => 'streets',
        ];

        // --- Kľúčová oprava: Zoradenie tabuliek podľa dĺžky kľúča (slovenského názvu) v zostupnom poradí ---
        // Tým sa zabezpečí, že sa najprv spracujú dlhšie reťazce (napr. 'chovatel_matiek'),
        // a zabráni sa tak chybnému nahradeniu podreťazca ('chovatel').
        uksort($originalTables, function($a, $b) {
            return strlen($b) <=> strlen($a);
        });
        // --------------------------------------------------------------------------------------------------

        // Cesta k pôvodnému SQL súboru
        $sqlPath = database_path('seeders/zchvm.sql');

        if (!File::exists($sqlPath)) {
            echo "Súbor SQL nebol nájdený na ceste: " . $sqlPath . "\n";
            return;
        }

        $sqlContent = File::get($sqlPath);

        // Načítanie celého obsahu a rozdelenie na jednotlivé príkazy
        $statements = array_filter(array_map('trim', explode(';', $sqlContent)));

        DB::beginTransaction();
        try {
            // Dočasné vypnutie kontroly cudzích kľúčov pri importe
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            foreach ($statements as $stmt) {
                $stmt = trim($stmt);

                // Preskočenie príkazov CREATE TABLE, DROP TABLE, ALTER TABLE, COMMENT, atď. (používame migrácie)
                if (str_starts_with(strtoupper($stmt), 'CREATE TABLE') ||
                    str_starts_with(strtoupper($stmt), 'DROP TABLE') ||
                    str_starts_with(strtoupper($stmt), 'ALTER TABLE') ||
                    str_starts_with(strtoupper($stmt), 'SET') ||
                    str_starts_with(strtoupper($stmt), 'START TRANSACTION') ||
                    str_starts_with(strtoupper($stmt), 'COMMIT') ||
                    empty($stmt)) {
                    continue;
                }

                // Logika prekladu názvu tabuľky LEN pri príkaze INSERT INTO
                if (str_starts_with(strtoupper($stmt), 'INSERT INTO')) {

                    // Prechádzame pole s prekladmi tabuliek (teraz zoradené od najdlhšej)
                    foreach ($originalTables as $oldName => $newName) {
                        // Regulárny výraz na nájdenie `oldName` po "INSERT INTO"
                        // `\s+` zabezpečuje medzery, `(` a `)` zabezpečujú optionalitu backtickov.
                        $pattern = '/^INSERT\s+INTO\s+(`?)' . preg_quote($oldName) . '(`?)/i';
                        $replacement = 'INSERT INTO `' . $newName . '`';

                        // Aplikujeme nahradenie len prvej zhody
                        $newStmt = preg_replace($pattern, $replacement, $stmt, 1);

                        // Ak došlo k nahradeniu, zastavíme hľadanie v tomto príkaze
                        if ($newStmt !== $stmt) {
                            $stmt = $newStmt;
                            break;
                        }
                    }
                }

                // Spustenie príkazu (hlavne INSERT)
                if (!empty($stmt)) {
                    DB::statement($stmt);
                }
            }

            // Zapnutie kontroly cudzích kľúčov späť
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::commit();
            echo "Dáta boli úspešne naimportované a názvy tabuliek v INSERT príkazoch preložené.\n";

        } catch (\Exception $e) {
            DB::rollback();
            // Zobrazenie chyby a SQL, ktoré ju spôsobilo, ak je to možné
            $stmtWithError = isset($stmt) ? substr($stmt, 0, 100) . '...' : 'N/A';
            echo "Chyba pri importe dát: " . $e->getMessage() . " (SQL začiatok: {$stmtWithError})\n";
        }
    }
}
