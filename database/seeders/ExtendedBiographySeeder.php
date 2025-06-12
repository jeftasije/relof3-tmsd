<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtendedBiography;
use App\Models\Employee;

class ExtendedBiographySeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all()->keyBy('id');

        ExtendedBiography::create([
            'employee_id' => 1,
            'biography' => 'Dragica je strastvena bibliotekarka sa 5 godina iskustva u radu sa mlađim čitaocima i digitalizacijom fonda. Dragica je takođe glavni koordinator za programe čitanja za decu uzrasta do 12 godina, a poznata je po svom toplom pristupu i interaktivnim pričanjima bajki. Organizovala je više humanitarnih događaja kako bi knjige bile dostupne i deci iz ruralnih područja. Učestvovala je u nacionalnim konferencijama o digitalizaciji kulturne baštine. Njena kolekcija digitalizovanih bajki postala je uzor za slične projekte širom Srbije. Dragica neprestano unapređuje svoje znanje kroz stručne seminare i radionice.',
            'university' => 'Filološki fakultet, Univerzitet u Beogradu',
            'experience' => '5 godina kao bibliotekar u narodnoj biblioteci, 2 godine u digitalizaciji knjižnog fonda.',
            'skills' => ['organizacija događaja', 'digitalizacija', 'rad sa decom', 'katalogizacija'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 2,
            'biography' => 'Marko se brine o tehničkoj opremi i informacionim sistemima biblioteke, sa fokusom na pristup elektronskim izvorima. Razvio je sistem za bežični pristup internetu koji pokriva celu biblioteku, uključujući čitaonice na otvorenom. Aktivno sarađuje sa timovima za zaštitu podataka i sigurnost sistema. Uveo je proces automatizovanih bezbednosnih kopija podataka, čime je znatno povećana otpornost bibliotečkog sistema. Marko takođe volontira kao mentor u lokalnim IT zajednicama i često piše blogove o upravljanju digitalnim resursima. Njegova stručnost čini biblioteku jednim od tehnološki najopremljenijih objekata u regiji.',
            'university' => 'Fakultet tehničkih nauka, Univerzitet u Novom Sadu',
            'experience' => '7 godina u administraciji informacionih sistema, 4 godine u bibliotekarskom sektoru.',
            'skills' => ['sistemska administracija', 'baze podataka', 'mrežna sigurnost', 'upravljanje softverom'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 3,
            'biography' => 'Jelena pomaže u obradi i izdavanju knjiga, kao i u organizaciji kulturnih događaja i radionica za decu. Njena posvećenost deci je neupitna, a često se može videti kako vodi decu kroz književne igre koje je sama osmislila. Uvela je sistem nagrađivanja za male čitaoce, motivišući ih da pročitaju više knjiga mesečno. Redovno sarađuje sa lokalnim školama i pedagozima na pripremi obrazovnih sadržaja. Jelena je učestvovala u međunarodnoj razmeni mladih bibliotekara, gde je predstavila svoj model inkluzivnih radionica. Trenutno radi na projektu digitalne platforme za dečju literaturu.',
            'university' => 'Učiteljski fakultet, Univerzitet u Beogradu',
            'experience' => '3 godine kao pomoćnik bibliotekara, 2 godine u organizaciji edukativnih radionica.',
            'skills' => ['organizacija radionica', 'komunikacija', 'katalogizacija', 'rad sa decom'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 4,
            'biography' => 'Nemanja vodi računa o čuvanju stare i retke građe, kao i o digitalnoj arhivi biblioteke. Njegova metodologija arhiviranja postala je model za druge ustanove. Razvio je sistem za praćenje stanja fizičkih dokumenata i njihovu hitnost za digitalizaciju. Nemanja je organizovao izložbe retkih dokumenata, uključujući i prvi štampani primerak lokalnog lista iz XIX veka. Takođe je predavač na radionicama za mlade istraživače o korišćenju arhivske građe. Njegov rad je nagrađen na sajmu biblioteka za doprinos očuvanju nacionalne kulturne baštine.',
            'university' => 'Filozofski fakultet, Univerzitet u Beogradu',
            'experience' => '6 godina u arhiviranju, 3 godine u digitalizaciji retke građe.',
            'skills' => ['arhiviranje', 'digitalizacija', 'upravljanje dokumentima', 'istraživanje'],
        ]);
    }
}
