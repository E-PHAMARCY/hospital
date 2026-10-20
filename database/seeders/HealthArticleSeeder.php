<?php

namespace Database\Seeders;

use App\Models\HealthArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HealthArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title_en' => 'Early Recognition of Stroke Symptoms: Act F.A.S.T.',
                'title_sw' => 'Kutambua Dalili za Mapema za Kiharusi: Chukua Hatua Haraka',
                'slug' => 'early-recognition-stroke-symptoms-fast',
                'category' => 'Neurology & Emergency',
                'author_name' => 'Ephamarcy Emergency Medicine Team',
                'excerpt_en' => 'Learn the critical F.A.S.T. signs (Face drooping, Arm weakness, Speech difficulty, Time to call emergency) that save lives during acute stroke episodes.',
                'excerpt_sw' => 'Fahamu dalili kuu za kiharusi (Kupooza kwa uso, Udhaifu wa mkono, Ugumu wa kuongea, Wahi hospitali haraka) kuokoa maisha.',
                'content_en' => 'Stroke is a medical emergency that occurs when blood flow to an area of the brain is interrupted. Every second counts because brain cells begin to starve of oxygen within minutes. Using the F.A.S.T. method: Face (is one side drooping?), Arms (can the person raise both arms?), Speech (is their speech slurred?), Time (call emergency immediately at +255742448965). Never attempt home remedies or waiting for symptoms to pass.',
                'content_sw' => 'Kiharusi ni dharura ya kitabibu inayotokea pale mtiririko wa damu kwenye ubongo unapokatika au kupungua ghafla. Kila sekunde ni muhimu sana kwa kuwa seli za ubongo zinaanza kufa ndani ya dakika chache. Tumia njia ya FAST: Uso (umelegea upande mmoja?), Mikono (anaweza kuinua mikono yote miwili?), Maongezi (maneno yanatoka kwa shida?), Muda (piga nambari ya dharura mara moja +255742448965).',
                'published_at' => Carbon::now()->subDays(5),
                'is_published' => true,
            ],
            [
                'title_en' => 'Maternal Wellness: Key Nutritional Priorities During Pregnancy',
                'title_sw' => 'Afya ya Mama Mjamzito: Lishe Bora Muhimu Wakati wa Ujauzito',
                'slug' => 'maternal-wellness-nutritional-priorities-pregnancy',
                'category' => 'Maternal & Child Health',
                'author_name' => 'Obstetrics Clinical Faculty',
                'excerpt_en' => 'Evidence-based advice on iron supplementation, folic acid intake, hydration, and wholesome local foods for healthy fetal development.',
                'excerpt_sw' => 'Ushauri wa kitabibu kuhusu virutubisho vya madini chuma, asidi ya foliki na vyakula bora vya asili kwa ukuaji mzuri wa mtoto.',
                'content_en' => 'Optimal nutrition during pregnancy supports both mother and developing child. Focus on daily iron and folic acid supplements as prescribed during antenatal visits. Incorporate leafy greens, lentils, clean proteins, and abundant hydration. Avoid raw or unpasteurized foods, and attend all scheduled clinical checkups at our Maternal and Child Wing.',
                'content_sw' => 'Lishe sahihi wakati wa ujauzito ni msingi wa afya ya mama na mtoto anayekua tumboni. Zingatia kumeza vidonge vya madini chuma na asidi ya foliki kama unavyoelekezwa kliniki. Kula mboga za majani, maharagwe, vyakula vyenye protini safi, na unywe maji ya kutosha. Epuka vyakula visivyoiva vizuri na hudhuria kliniki mara kwa mara.',
                'published_at' => Carbon::now()->subDays(12),
                'is_published' => true,
            ],
            [
                'title_en' => 'Managing Type 2 Diabetes Through Lifestyle & Clinical Care',
                'title_sw' => 'Kudhibiti Ugonjwa wa Kisukari Kupitia Mtindo wa Maisha na Matibabu',
                'slug' => 'managing-diabetes-lifestyle-clinical-care',
                'category' => 'Chronic Disease Management',
                'author_name' => 'Department of Internal Medicine',
                'excerpt_en' => 'Understanding glycemic monitoring, physical activity, dietary adjustments, and medication adherence to prevent vascular complications.',
                'excerpt_sw' => 'Umuhimu wa kupima sukari mara kwa mara, mazoezi, mpangilio mzuri wa chakula na kufuata ushauri wa dawa.',
                'content_en' => 'Type 2 diabetes requires consistent daily partnership between patient and medical team. Monitoring fasting glucose levels, adopting moderate aerobic exercises (like 30 minutes of brisk walking), reducing refined carbohydrates, and strictly adhering to prescribed oral hypoglycemics or insulin form the pillars of long-term complication prevention.',
                'content_sw' => 'Ugonjwa wa kisukari unahitaji ushirikiano wa karibu kati ya mgonjwa na daktari wake. Kupima viwango vya sukari ya asubuhi, kufanya mazoezi mepesi kama kutembea dakika 30 kila siku, kupunguza wanga na sukari, na kuzingatia dawa husaidia kuzuia madhara kwenye macho, figo na moyo.',
                'published_at' => Carbon::now()->subDays(20),
                'is_published' => true,
            ],
        ];

        foreach ($articles as $art) {
            HealthArticle::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
