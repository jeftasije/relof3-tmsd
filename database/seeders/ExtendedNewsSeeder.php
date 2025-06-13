<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtendedNews;

class ExtendedNewsSeeder extends Seeder
{
    public function run()
    {
        $extendedNews = [
            [
                'news_id' => 1,
                'content' => 'Narodna biblioteka je dobila novu čitaonicu opremljenu modernim nameštajem i pristupom digitalnim izvorima. Posetioci sada mogu uživati u mirnom prostoru za čitanje i istraživanje. Svečano otvaranje nove čitaonice upriličeno je uz prisustvo predstavnika lokalne samouprave, zaposlenih u biblioteci i brojnih građana. Nova čitaonica rezultat je višemesečne adaptacije prostora u okviru šireg projekta modernizacije biblioteških usluga. Pored klasičnih štampanih izdanja, posetiocima je sada omogućen i pristup velikom broju elektronskih knjiga i stručnih baza podataka. Savremeni enterijer i funkcionalan raspored sedenja pružaju idealne uslove za individualni rad, ali i grupne aktivnosti. Direktor biblioteke istakao je da je cilj ove investicije bio da se odgovori na potrebe savremenih korisnika. Posebna pažnja posvećena je dostupnosti, pa je prostor u potpunosti prilagođen osobama sa invaliditetom. U čitaonici su postavljeni i računari sa pristupom internetu, čime je dodatno olakšan istraživački rad i učenje. Uvođenjem ovakvih sadržaja biblioteka nastavlja da se razvija kao savremeni kulturni i obrazovni centar. Očekuje se da će nova čitaonica doprineti većem interesovanju mladih za čitanje i korišćenje biblioteških usluga.',
                'tags' => json_encode(['čitaonica', 'biblioteka', 'infrastruktura']),
            ],
            [
                'news_id' => 2,
                'content' => 'Predavanje je održano u velikoj sali biblioteke, gde je profesor Dragan izneo ključne momente srpske književnosti kroz vekove, sa posebnim osvrtom na modernizam. Događaju je prisustvovao veliki broj ljubitelja književnosti, među kojima su bili studenti, profesori i građani različitih generacija. Profesor je kroz inspirativno izlaganje povezao istorijski kontekst sa književnim tokovima, ukazujući na uticaje evropskih pravaca na domaće autore. Posebna pažnja bila je posvećena stvaralaštvu pisaca poput Crnjanskog, Andrića i Pekića. Publika je s pažnjom pratila predavanje, koje je obogaćeno citatima i anegdotama iz književnog života. Nakon izlaganja usledila je diskusija, tokom koje su posetioci imali priliku da postavljaju pitanja i iznesu sopstvene osvrte. Organizatori ističu da je ovakav vid programa važan za popularizaciju književnosti i razvoj kritičkog mišljenja. Predavanje je deo šireg ciklusa kulturnih događaja koje biblioteka realizuje tokom godine. Posebno je pohvaljena interaktivnost predavanja i način na koji je profesor približio kompleksne teme široj publici. Sledeće predavanje iz ovog ciklusa najavljeno je za naredni mesec i biće posvećeno poeziji savremenih srpskih autora.',
                'tags' => json_encode(['predavanje', 'književnost', 'istorija']),
            ],
            [
                'news_id' => 3,
                'content' => 'Radionica je bila fokusirana na korišćenje računara, interneta i osnovnih digitalnih alata, sa ciljem da se unaprede digitalne veštine odraslih polaznika. Održana je u prostorijama biblioteke koje su opremljene savremenom IT opremom i stabilnom internet vezom. Učesnici su imali priliku da kroz praktične vežbe savladaju osnove rada u programima poput Worda i Excela, kao i bezbedno korišćenje interneta. Predavači su se potrudili da svako pitanje bude pažljivo razjašnjeno, uz individualan pristup svakom polazniku. Radionica je posebno bila namenjena starijim sugrađanima koji nisu imali prethodno iskustvo sa digitalnim tehnologijama. Organizatori ističu da je cilj programa digitalno osnaživanje i smanjenje digitalnog jaza u lokalnoj zajednici. Učesnicima su na kraju radionice podeljene brošure sa uputstvima za dalje samostalno vežbanje. Atmosfera tokom celog događaja bila je pozitivna i podržavajuća, što je dodatno motivisalo učesnike da se aktivno uključe. Program je realizovan u saradnji sa lokalnom samoupravom i uz podršku Ministarstva za informisanje i telekomunikacije. Zbog velikog interesovanja, najavljeno je održavanje dodatnih radionica u narednim mesecima.',
                'tags' => json_encode(['radionica', 'digitalna pismenost', 'edukacija']),
            ],
            [
                'news_id' => 4,
                'content' => 'Izložba retkih knjiga obuhvata manuskripte i prva izdanja značajnih dela koja su sačuvana u biblioteci tokom više decenija. Postavka je otvorena u galerijskom prostoru biblioteke i već pri prvom danu izazvala je veliko interesovanje javnosti. Među izloženim eksponatima nalaze se dela iz 18. i 19. veka, uključujući rukopisne zbirke pesama, originalna pisma autora i bibliografski dragocene knjige. Poseban segment izložbe posvećen je domaćim klasicima, čija su prva izdanja prikazana uz kontekstualna objašnjenja i biografske detalje. Posetioci imaju priliku da uz stručno vođenje saznaju više o istorijatu svakog dela i okolnostima njegovog nastanka. Izložbu prate i interaktivni sadržaji poput digitalnog listanja odabranih stranica najvrednijih primeraka. Organizatori naglašavaju da je cilj postavke edukacija i očuvanje kulturne baštine za buduće generacije. Prikazana dela deo su specijalnog fonda biblioteke, koji se retko izlaže zbog svoje osetljivosti i vrednosti. Program je realizovan uz podršku Zavoda za zaštitu spomenika kulture i traje do kraja meseca. Ulaz je slobodan, a svi posetioci dobijaju informativni katalog sa opisom izloženih knjiga.',
                'tags' => json_encode(['izložba', 'knjige', 'retko']),
            ],
            [
                'news_id' => 5,
                'content' => 'Članovi biblioteke sada imaju pristup novim elektronskim knjigama koje mogu čitati online ili preuzeti za offline čitanje. Ova novina uvedena je kao deo digitalizacije usluga, sa ciljem da se savremeni sadržaji učine dostupnijim široj publici. Katalog e-knjiga obuhvata domaće i strane autore, stručnu literaturu, beletristiku i naslove za decu. Pristup se ostvaruje jednostavnom prijavom na platformu putem članske kartice biblioteke. Korisnici mogu čitati knjige putem računara, tableta ili mobilnog telefona, bez potrebe za dodatnim softverom. Sistem je prilagođen osobama sa oštećenim vidom i uključuje opciju promene veličine slova i kontrasta. Bibliotekari su obučeni da pomognu korisnicima u savladavanju digitalne platforme. Očekuje se da će ova usluga doprineti većem čitalačkom angažovanju, naročito među mlađom populacijom. Inicijativa je realizovana uz podršku Ministarstva kulture i finansirana sredstvima iz fondova EU. Biblioteka planira da u narednom periodu dodatno proširi digitalni fond i uvede audioknjige kao sledeći korak.',
                'tags' => json_encode(['elektronske knjige', 'digitalni fond', 'biblioteka']),
            ],
        ];

        foreach ($extendedNews as $item) {
            ExtendedNews::create($item);
        }
    }
}
