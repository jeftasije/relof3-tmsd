<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\History;


class HistorySeeder extends Seeder
{
    public function run(): void
    {
        History::create([
            'content' => 'Početkom 20. veka, Novi Pazar je bio kulturno i ekonomski nerazvijen. Kulturni život je bio podeljen po verskoj liniji: muslimani su imali privatne biblioteke u kućama i džamijama, a pravoslavno stanovništvo u okviru crkveno-školskih opština.

            Prva štamparija se pojavila 1912, a prvi lokalni list 1921. godine. Prva javna biblioteka osnovana je 30. juna 1921. U međuratnom periodu biblioteke su uglavnom postojale u školama. Tokom Drugog svetskog rata fond knjiga je uglavnom uništen ili izgubljen.

            Nakon rata, 23. decembra 1944. godine osnovana je Narodna biblioteka. Iako je počela u teškim uslovima, već 1957. postaje Gradska biblioteka „Dositej Obradović“. Narednih decenija se razvija, a 1983. postaje matična biblioteka opštine.

            Od 1996. nalazi se u zgradi u Gradskom parku. Modernizacija počinje 2006. godine uvođenjem COBISS sistema i elektronske pozajmice knjiga.

            Danas biblioteka ima 25 zaposlenih, 10 odeljenja, oko 80.000 knjiga i 5.000 aktivnih članova godišnje. Ona ostaje ključna kulturna ustanova Novog Pazara.',

            
            'content_en' => 'At the beginning of the 20th century, Novi Pazar was a culturally and economically underdeveloped town. Cultural life was divided along religious lines: Muslims maintained private libraries in homes and mosques, while the Orthodox community organized church libraries and reading rooms.

            In 1912, the first printing press appeared, followed by the first local newspaper in 1921. The first public library in Novi Pazar was officially established on June 30, 1921. During the interwar period, libraries mainly existed within schools. World War II brought devastation—most books were destroyed or lost.

            After the war, efforts were made to rebuild. The People’s Library was founded on December 23, 1944. Despite modest beginnings in poor facilities, by 1957 it became the “Dositej Obradović” City Library. Over the next decades, it expanded its collection and services, becoming the municipal reference library in 1983.

            In 1996, it moved to its current building in the city park. Modernization began in 2006 with the introduction of the COBISS system and electronic lending.

            Today, the library has 25 employees, 10 departments, about 80,000 books, and around 5,000 active members yearly. It remains a key cultural institution in Novi Pazar.',

            
            'content_cy' => 'Почетком 20. века, Нови Пазар је био културно и економски неразвијен. Културни живот је био подељен по верској линији: муслимани су имали приватне библиотеке у кућама и џамијама, а православно становништво у оквиру црквено-школских општина.

            Прва штампарија се појавила 1912, а први локални лист 1921. године. Прва јавна библиотека основана је 30. јуна 1921. У међуратном периоду библиотеке су углавном постојале у школама. Током Другог светског рата фонд књига је углавном уништен или изгубљен.

            Након рата, 23. децембра 1944. године основана је Народна библиотека. Иако је почела у тешким условима, већ 1957. постаје Градска библиотека „Доситеј Обрадовић“. Наредних деценија се развија, а 1983. постаје матична библиотека општине.

            Од 1996. налази се у згради у Градском парку. Модернизација почиње 2006. године увођењем COBISS система и електронске позајмице књига.

            Данас библиотека има 25 запослених, 10 одељења, око 80.000 књига и 5.000 активних чланова годишње. Она остаје кључна културна установа Новог Пазара.'
        ]);
    }
}
