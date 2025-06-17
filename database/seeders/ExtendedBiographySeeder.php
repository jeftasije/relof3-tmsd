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
            'biography_translated' => 'Dragica is a passionate librarian with 5 years of experience working with young readers and digitizing collections. She is also the main coordinator for reading programs for children up to 12 years old, known for her warm approach and interactive storytelling. She organized several charity events to make books accessible to children in rural areas. Participated in national conferences on cultural heritage digitization. Her collection of digitized fairy tales became a model for similar projects across Serbia. Dragica continuously improves her knowledge through professional seminars and workshops.',
            'university' => 'Filološki fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Philology, University of Belgrade',
            'experience' => '5 godina kao bibliotekar u narodnoj biblioteci, 2 godine u digitalizaciji knjižnog fonda.',
            'experience_translated' => '5 years as a librarian in the national library, 2 years in digitizing book collections.',
            'skills' => ['organizacija događaja', 'digitalizacija', 'rad sa decom', 'katalogizacija'],
            'skills_translated' => ['event organization', 'digitization', 'working with children', 'cataloging'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 2,
            'biography' => 'Marko se brine o tehničkoj opremi i informacionim sistemima biblioteke, sa fokusom na pristup elektronskim izvorima. Razvio je sistem za bežični pristup internetu koji pokriva celu biblioteku, uključujući čitaonice na otvorenom. Aktivno sarađuje sa timovima za zaštitu podataka i sigurnost sistema. Uveo je proces automatizovanih bezbednosnih kopija podataka, čime je znatno povećana otpornost bibliotečkog sistema. Marko takođe volontira kao mentor u lokalnim IT zajednicama i često piše blogove o upravljanju digitalnim resursima. Njegova stručnost čini biblioteku jednim od tehnološki najopremljenijih objekata u regiji.',
            'biography_translated' => 'Marko manages the library\'s technical equipment and information systems, focusing on access to electronic resources. He developed a wireless internet system covering the entire library, including outdoor reading rooms. Actively collaborates with data protection and system security teams. Introduced automated backup processes, significantly increasing the library system\'s resilience. Marko also volunteers as a mentor in local IT communities and frequently writes blogs about managing digital resources. His expertise makes the library one of the most technologically equipped facilities in the region.',
            'university' => 'Fakultet tehničkih nauka, Univerzitet u Novom Sadu',
            'university_translated' => 'Faculty of Technical Sciences, University of Novi Sad',
            'experience' => '7 godina u administraciji informacionih sistema, 4 godine u bibliotekarskom sektoru.',
            'experience_translated' => '7 years in information systems administration, 4 years in the library sector.',
            'skills' => ['sistemska administracija', 'baze podataka', 'mrežna sigurnost', 'upravljanje softverom'],
            'skills_translated' => ['system administration', 'databases', 'network security', 'software management'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 3,
            'biography' => 'Jelena pomaže u obradi i izdavanju knjiga, kao i u organizaciji kulturnih događaja i radionica za decu. Njena posvećenost deci je neupitna, a često se može videti kako vodi decu kroz književne igre koje je sama osmislila. Uvela je sistem nagrađivanja za male čitaoce, motivišući ih da pročitaju više knjiga mesečno. Redovno sarađuje sa lokalnim školama i pedagozima na pripremi obrazovnih sadržaja. Jelena je učestvovala u međunarodnoj razmeni mladih bibliotekara, gde je predstavila svoj model inkluzivnih radionica. Trenutno radi na projektu digitalne platforme za dečju literaturu.',
            'biography_translated' => 'Jelena assists in book processing and publishing, as well as organizing cultural events and workshops for children. Her dedication to children is unquestionable, and she is often seen leading children through literary games she created herself. She introduced a reward system for young readers, motivating them to read more books monthly. Regularly cooperates with local schools and educators in preparing educational content. Jelena participated in an international exchange of young librarians, presenting her model of inclusive workshops. Currently working on a digital platform project for children\'s literature.',
            'university' => 'Učiteljski fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Teacher Education, University of Belgrade',
            'experience' => '3 godine kao pomoćnik bibliotekara, 2 godine u organizaciji edukativnih radionica.',
            'experience_translated' => '3 years as librarian assistant, 2 years organizing educational workshops.',
            'skills' => ['organizacija radionica', 'komunikacija', 'katalogizacija', 'rad sa decom'],
            'skills_translated' => ['workshop organization', 'communication', 'cataloging', 'working with children'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 4,
            'biography' => 'Nemanja vodi računa o čuvanju stare i retke građe, kao i o digitalnoj arhivi biblioteke. Njegova metodologija arhiviranja postala je model za druge ustanove. Razvio je sistem za praćenje stanja fizičkih dokumenata i njihovu hitnost za digitalizaciju. Nemanja je organizovao izložbe retkih dokumenata, uključujući i prvi štampani primerak lokalnog lista iz XIX veka. Takođe je predavač na radionicama za mlade istraživače o korišćenju arhivske građe. Njegov rad je nagrađen na sajmu biblioteka za doprinos očuvanju nacionalne kulturne baštine.',
            'biography_translated' => 'Nemanja is responsible for preserving old and rare materials as well as the library\'s digital archive. His archiving methodology has become a model for other institutions. Developed a system for monitoring the condition of physical documents and their urgency for digitization. Organized exhibitions of rare documents, including the first printed copy of a local newspaper from the 19th century. Also a lecturer at workshops for young researchers on using archival materials. His work was awarded at the library fair for contribution to the preservation of national cultural heritage.',
            'university' => 'Filozofski fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Philosophy, University of Belgrade',
            'experience' => '6 godina u arhiviranju, 3 godine u digitalizaciji retke građe.',
            'experience_translated' => '6 years in archiving, 3 years in digitizing rare materials.',
            'skills' => ['arhiviranje', 'digitalizacija', 'upravljanje dokumentima', 'istraživanje'],
            'skills_translated' => ['archiving', 'digitization', 'document management', 'research'],
        ]);
    }
}