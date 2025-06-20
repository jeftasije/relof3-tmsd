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
            'biography_cy' => 'Драгица је страствена библиотекарка са 5 година искуства у раду са млађим читаоцима и дигитализацијом фонда. Драгица је такође главни координатор за програме читања за децу узраста до 12 година, а позната је по свом топлом приступу и интерактивним причањима бајки. Организовала је више хуманитарних догађаја како би књиге биле доступне и деци из руралних подручја. Учестовала је у националним конференцијама о дигитализацији културне баштине. Њена колекција дигитализованих бајки постала је узор за сличне пројекте широм Србије. Драгица непрестано унапређује своје знање кроз стручне семинаре и радионице.',
            'university' => 'Filološki fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Philology, University of Belgrade',
            'university_cy' => 'Филолошки факултет, Универзитет у Београду',
            'experience' => '5 godina kao bibliotekar u narodnoj biblioteci, 2 godine u digitalizaciji knjižnog fonda.',
            'experience_translated' => '5 years as a librarian in the national library, 2 years in digitizing book collections.',
            'experience_cy' => '5 година као библиотекар у народној библиотеци, 2 године у дигитализацији књижног фонда.',
            'skills' => ['organizacija događaja', 'digitalizacija', 'rad sa decom', 'katalogizacija'],
            'skills_translated' => ['event organization', 'digitization', 'working with children', 'cataloging'],
            'skills_cy' => ['организација догађаја', 'дигитализација', 'рад са децом', 'каталогизација'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 2,
            'biography' => 'Marko se brine o tehničkoj opremi i informacionim sistemima biblioteke, sa fokusom na pristup elektronskim izvorima. Razvio je sistem za bežični pristup internetu koji pokriva celu biblioteku, uključujući čitaonice na otvorenom. Aktivno sarađuje sa timovima za zaštitu podataka i sigurnost sistema. Uveo je proces automatizovanih bezbednosnih kopija podataka, čime je znatno povećana otpornost bibliotečkog sistema. Marko takođe volontira kao mentor u lokalnim IT zajednicama i često piše blogove o upravljanju digitalnim resursima. Njegova stručnost čini biblioteku jednim od tehnološki najopremljenijih objekata u regiji.',
            'biography_translated' => 'Marko manages the library\'s technical equipment and information systems, focusing on access to electronic resources. He developed a wireless internet system covering the entire library, including outdoor reading rooms. Actively collaborates with data protection and system security teams. Introduced automated backup processes, significantly increasing the library system\'s resilience. Marko also volunteers as a mentor in local IT communities and frequently writes blogs about managing digital resources. His expertise makes the library one of the most technologically equipped facilities in the region.',
            'biography_cy' => 'Марко се брине о техничкој опреми и информационим системима библиотеке, са фокусом на приступ електронским изворима. Развио је систем за бежични приступ интернету који покрива целу библиотеку, укључујући читаонице на отвореном. Активно сарађује са тимовима за заштиту података и сигурност система. Увео је процес аутоматизованих безбедносних копија података, чиме је знатно повећана отпорност библиотечког система. Марко такође волонтира као ментор у локалним ИТ заједницама и често пише блогове о управљању дигиталним ресурсима. Његова стручност чини библиотеку једним од технолошки најопремљенијих објеката у региону.',
            'university' => 'Fakultet tehničkih nauka, Univerzitet u Novom Sadu',
            'university_translated' => 'Faculty of Technical Sciences, University of Novi Sad',
            'university_cy' => 'Факултет техничких наука, Универзитет у Новом Саду',
            'experience' => '7 godina u administraciji informacionih sistema, 4 godine u bibliotekarskom sektoru.',
            'experience_translated' => '7 years in information systems administration, 4 years in the library sector.',
            'experience_cy' => '7 година у администрацији информационих система, 4 године у библиотекарском сектору.',
            'skills' => ['sistemska administracija', 'baze podataka', 'mrežna sigurnost', 'upravljanje softverom'],
            'skills_translated' => ['system administration', 'databases', 'network security', 'software management'],
            'skills_cy' => ['системска администрација', 'базе података', 'мрежна сигурност', 'управљање софтвером'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 3,
            'biography' => 'Jelena pomaže u obradi i izdavanju knjiga, kao i u organizaciji kulturnih događaja i radionica za decu. Njena posvećenost deci je neupitna, a često se može videti kako vodi decu kroz književne igre koje je sama osmislila. Uvela je sistem nagrađivanja za male čitaoce, motivišući ih da pročitaju više knjiga mesečno. Redovno sarađuje sa lokalnim školama i pedagozima na pripremi obrazovnih sadržaja. Jelena je učestvovala u međunarodnoj razmeni mladih bibliotekara, gde je predstavila svoj model inkluzivnih radionica. Trenutno radi na projektu digitalne platforme za dečju literaturu.',
            'biography_translated' => 'Jelena assists in book processing and publishing, as well as organizing cultural events and workshops for children. Her dedication to children is unquestionable, and she is often seen leading children through literary games she created herself. She introduced a reward system for young readers, motivating them to read more books monthly. Regularly cooperates with local schools and educators in preparing educational content. Jelena participated in an international exchange of young librarians, presenting her model of inclusive workshops. Currently working on a digital platform project for children\'s literature.',
            'biography_cy' => 'Јелена помаже у обради и издавању књига, као и у организацији културних догађаја и радионица за децу. Њена посвећеност деци је неупитна, а често се може видети како води децу кроз књижевне игре које је сама осмислила. Увела је систем награђивања за мале читаоце, мотивишући их да прочитају више књига месечно. Редовно сарађује са локалним школама и педагозима на припреми образовних садржаја. Јелена је учествовала у међународној размени младих библиотекара, где је представила свој модел инклузивних радионица. Тренутно ради на пројекту дигиталне платформе за дечју литературу.',
            'university' => 'Učiteljski fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Teacher Education, University of Belgrade',
            'university_cy' => 'Учитељски факултет, Универзитет у Београду',
            'experience' => '3 godine kao pomoćnik bibliotekara, 2 godine u organizaciji edukativnih radionica.',
            'experience_translated' => '3 years as librarian assistant, 2 years organizing educational workshops.',
            'experience_cy' => '3 године као помоћник библиотекара, 2 године у организацији едукативних радионица.',
            'skills' => ['organizacija radionica', 'komunikacija', 'katalogizacija', 'rad sa decom'],
            'skills_translated' => ['workshop organization', 'communication', 'cataloging', 'working with children'],
            'skills_cy' => ['организација радионица', 'комуникација', 'каталогизација', 'рад са децом'],
        ]);

        ExtendedBiography::create([
            'employee_id' => 4,
            'biography' => 'Nemanja vodi računa o čuvanju stare i retke građe, kao i o digitalnoj arhivi biblioteke. Njegova metodologija arhiviranja postala je model za druge ustanove. Razvio je sistem za praćenje stanja fizičkih dokumenata i njihovu hitnost za digitalizaciju. Nemanja je organizovao izložbe retkih dokumenata, uključujući i prvi štampani primerak lokalnog lista iz XIX veka. Takođe je predavač na radionicama za mlade istraživače o korišćenju arhivske građe. Njegov rad je nagrađen na sajmu biblioteka za doprinos očuvanju nacionalne kulturne baštine.',
            'biography_translated' => 'Nemanja is responsible for preserving old and rare materials as well as the library\'s digital archive. His archiving methodology has become a model for other institutions. Developed a system for monitoring the condition of physical documents and their urgency for digitization. Organized exhibitions of rare documents, including the first printed copy of a local newspaper from the 19th century. Also a lecturer at workshops for young researchers on using archival materials. His work was awarded at the library fair for contribution to the preservation of national cultural heritage.',
            'biography_cy' => 'Немања води рачуна о чувању старе и ретке грађе, као и о дигиталној архиви библиотеке. Његова методологија архивирања постала је модел за друге установе. Развио је систем за праћење стања физичких докумената и њихову хитност за дигитализацију. Немања је организовао изложбе ретких докумената, укључујући и први штампани примерак локалног листа из XIX века. Такође је предавач на радионицама за младе истраживаче о коришћењу архивске грађе. Његов рад је награђен на сајму библиотека за допринос очувању националне културне баштине.',
            'university' => 'Filozofski fakultet, Univerzitet u Beogradu',
            'university_translated' => 'Faculty of Philosophy, University of Belgrade',
            'university_cy' => 'Филозофски факултет, Универзитет у Београду',
            'experience' => '6 godina u arhiviranju, 3 godine u digitalizaciji retke građe.',
            'experience_translated' => '6 years in archiving, 3 years in digitizing rare materials.',
            'experience_cy' => '6 година у архивирању, 3 године у дигитализацији ретке грађе.',
            'skills' => ['arhiviranje', 'digitalizacija', 'upravljanje dokumentima', 'istraživanje'],
            'skills_translated' => ['archiving', 'digitization', 'document management', 'research'],
            'skills_cy' => ['архивирање', 'дигитализација', 'управљање документима', 'истраживање'],
        ]);
    }
}