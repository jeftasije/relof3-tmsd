<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question'     => 'Koje su radne sate biblioteke?',
                'question_en'  => 'What are the library opening hours?',
                'question_cy'  => 'Које су радне сате библиотеке?',
                'answer'       => 'Biblioteka je otvorena radnim danima od 8:00 do 16:00.',
                'answer_en'    => 'The library is open on weekdays from 8:00 AM to 4:00 PM.',
                'answer_cy'    => 'Библиотека је отворена радним данима од 8:00 до 16:00.',
            ],
            [
                'question'     => 'Kako mogu da pozajmim knjigu?',
                'question_en'  => 'How can I borrow a book?',
                'question_cy'  => 'Како могу да позајмим књигу?',
                'answer'       => 'Potrebno je da imate važeću člansku kartu i da se prijavite na šalteru.',
                'answer_en'    => 'You need a valid membership card and to register at the counter.',
                'answer_cy'    => 'Потребно је да имате важећу чланску карту и да се пријавите на шалтеру.',
            ],
            [
                'question'     => 'Koliko dugo mogu zadržati knjigu?',
                'question_en'  => 'How long can I keep a book?',
                'question_cy'  => 'Колико дуго могу задржати књигу?',
                'answer'       => 'Knjige se mogu zadržati do 30 dana sa mogućnošću produženja.',
                'answer_en'    => 'Books can be kept for up to 30 days with the option to renew.',
                'answer_cy'    => 'Књиге се могу задржати до 30 дана са могућношћу продужења.',
            ],
            [
                'question'     => 'Koja su pravila za korišćenje računara u biblioteci?',
                'question_en'  => 'What are the rules for using computers in the library?',
                'question_cy'  => 'Која су правила за коришћење рачунара у библиотеци?',
                'answer'       => 'Računari se koriste isključivo za obrazovne i istraživačke svrhe.',
                'answer_en'    => 'Computers are to be used strictly for educational and research purposes.',
                'answer_cy'    => 'Рачунари се користе искључиво за образовне и истраживачке сврхе.',
            ],
            [
                'question'     => 'Da li biblioteka nudi besplatni Wi-Fi?',
                'question_en'  => 'Does the library offer free Wi-Fi?',
                'question_cy'  => 'Да ли библиотека нуди бесплатни Wi-Fi?',
                'answer'       => 'Da, besplatni Wi-Fi je dostupan svim posetiocima.',
                'answer_en'    => 'Yes, free Wi-Fi is available to all visitors.',
                'answer_cy'    => 'Да, бесплатни Wi-Fi је доступан свим посетиоцима.',
            ],
            [
                'question'     => 'Kako mogu produžiti rok vraćanja knjige?',
                'question_en'  => 'How can I extend the return date of a book?',
                'question_cy'  => 'Како могу продужити рок враћања књиге?',
                'answer'       => 'Produženje se može obaviti telefonom ili lično pre isteka roka.',
                'answer_en'    => 'Extension can be done by phone or in person before the due date.',
                'answer_cy'    => 'Продужење се може обавити телефоном или лично пре истека рока.',
            ],
            [
                'question'     => 'Da li biblioteka ima dečiji odeljak?',
                'question_en'  => 'Does the library have a children’s section?',
                'question_cy'  => 'Да ли библиотека има дечији одељак?',
                'answer'       => 'Da, imamo poseban odeljak sa knjigama za decu svih uzrasta.',
                'answer_en'    => 'Yes, we have a dedicated section with books for children of all ages.',
                'answer_cy'    => 'Да, имамо посебан одељак са књигама за децу свих узраста.',
            ],
        ];

        foreach ($questions as $data) {
            Question::create($data);
        }
    }
}
