<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    #[Route('', name: 'app_main', methods: ['GET'])]
    public function main(): Response
    {
        return $this->render('main_page.html.twig');
    }

    #[Route('/sleep-analyze', name: 'sleep_analyze', methods: ['POST'])]
    public function sleepAnalyze(Request $request, KernelInterface $kernel, HttpClientInterface $httpClient)
    {
        ini_set("max_execution_time", 1200);
        $data = $request->request->all();

        $gender = @$data['gender'];
        $age = @$data['age'];
        $job = @$data['job'];
        $sleepDuration = @$data['sleep_duration'];
        $nightAwakenings = @$data['night_awakenings'];
        $sleepQuality = @$data['sleep_quality'];
        $lifeDescription = @$data["short_life_description"];

        $projectDir = $kernel->getProjectDir();
        $csvPath = $projectDir . '/public/datasets/Sleep_health_and_lifestyle_dataset.csv';

        if (!file_exists($csvPath)) {
            throw $this->createNotFoundException('Dosya bulunamadı');
        }

        $csvContent = file_get_contents($csvPath);
        $prompt = <<<EOT
            Sen uzman bir Uyku Bilimcisi ve Psikologsun. Analiz yaparken sadece sayısal verilere değil, kullanıcının "öznel algısı" ile "nesnel verileri" arasındaki tutarsızlığa da odaklanmalısın.

            ### 1. REFERANS VERİ SETİ (CSV):
            $csvContent

            ### 2. KULLANICI PROFİLİ:
            - Cinsiyet: $gender(Male ise Erkek, Female ise Kadın yaz) | Yaş: $age | Meslek: $job
            - Uyku Süresi: $sleepDuration saat | Gece Uyanma Sayısı: $nightAwakenings | Öznel Kalite: $sleepQuality/10
            - Yaşam Tarzı: $lifeDescription

            ### Uyku Bozukluğu Hastalıkları ve Belirtileri
            İnsomniya:
            Gece boyunca uykuya geçme zorluğu
            Gece sık sık uyanma
            Sabah erken uyanma ve tekrar uyuyamama
            Yetersiz uyku nedeniyle gündüz yorgunluk, sinirlilik veya konsantrasyon güçlüğü

            Hipersomniya:
            Gün içinde aşırı uyuma isteği
            Uzun süre uyuma ve hâlâ yorgun hissetme
            Uyandıktan sonra baş ağrısı veya kas ağrıları

            Narkolepsi:
            Gün içinde aniden ve kontrolsüz bir şekilde uykuya dalma (narkoleptik ataklar)
            Kas tonusunun kaybı (katapleksi) veya kaslarda zayıflık
            Halüsinasyonlar ve uyku felci

            Uyku Apneleri:
            Gece boyunca horlama
            Solunumun geçici olarak durması
            Sabah ağız kuruluğu veya boğaz ağrısı
            Gündüz aşırı uyku hali veya yorgunluk

            Uykuda Hareket Bozuklukları:
            Uykuda yürüyüş (somnambulizm), konuşma veya diğer hareketler
            Uykuda istemsiz kas kasılmaları
            Uyandığınızda yorgunluk veya uykusuzluk hissi

            Uyku Döngüsünün Kayması:
            Uyku saatlerinde düzensizlik, örneğin gece geç saatte uyuma ve sabah geç kalkma
            Uyku düzeninin sürekli değişmesi
            Gündüz yorgunluk veya uyuklama

            ### 3. ÖZEL ANALİZ TALİMATLARI (KRİTİK):
            Aşağıdaki mantık çerçevesinde analiz et:

            A) VERİSEL KIYAS: Kullanıcının verilerini CSV'deki tüm sütun değerleri ile kıyasla. (Her değeri her sütun ile değil. Uygun sütun değerleri ile kıyaslama yap)
            B) ALGILANAN VS. GERÇEK: Kullanıcının uyku kalitesi düşük ama yaşam tarzı düzgünse başka bir ihtimal değerlendir. Ama yaşam tarzında da kötü belirtiler varsa uyku bozukluğu ile ilgili "Uyku Bozukluğu Hastalıkları ve Belirtileri"
            bölümünden bir hastalık tahmini yapabilirsin.
            C) BİLİŞSEL YÜK: $lifeDescription ve diğe bilgileri tartış.
            D) SONUÇ: Girilen bilgilere göre gerçek bir analiz yap. Girilen bilgiler : $gender, $age, $job, $sleepDuration, $nightAwakenings, $sleepQuality, $lifeDescription. Ayrıca kullanıcı $lifeDescription içinde
            bazı belirtiler girmişse bir hastalık tahmini de yapabilirsin(Hastalığı o belirtilere göre yap lütfen) Belirtilere göre hastalıkları "Uyku Bozukluğu Hastalıkları ve Belirtileri" kısmındaki bilgilerden
            yararlanabilirsin. Ayrıca sonuçların referans noktası her zaman CSV içerisindeki örnekler olmalı

            ### NOTES
            **Kullanıcı Verileri:** cevap içerisinde kesinlikle dönmeli. Her değer alt alta gelmeli. Cinsiyet: ... <br> Yaş: ... <br> gibi tüm değerler dönmeli.
            **CSV Grupları:** cevap içerisinde kesinlik dönmesin
            **Kiymetli Kullanıcı'nın** diye bir şey kesinlikle yazmasın. Kullanıcın yazabilir veya daha profesyone lbir kelime kullanabilirsin
            **Kiymetli Kullanıcı'nın Verileri ile CSV Grubu Kıyaslaması:** bu bölüm kesinlik olmasın. Bunun yerine genel bir değerlendirme yap.
            Cevaplarda D) Sonuç gibi başlıklar olmasın. SAdece Sonuç olabilir veya Bilişsel yük gibi. aynı şekilde 2. Kullanıcı profili gibi yazmasın. SAdece Kullanıcı Profile yazabilir.
            Cevaplar HTML formatında dönsün. Fakat ```html bu değerler olmasın cevapta. Örnepin başlıklar <b>Kullanıcı Profili</b> gibi dönsün. Başlıkların cevapları da div tagı içinde dönebilir. Ayrıca boşluk gerekiyorsa br ekleyebilirsin
            A) VERİSEL KIYAS: - B) ALGILANAN VS. GERÇEK - C) BİLİŞSEL YÜK: - D) SONUÇ: cevapları sonrası <br><br> tagını koymayı unutma. <br><br> tagları cevaplardan sonra eklenmeli başlıktan sonra değil.
        EOT;
        $response = $httpClient->request('POST', 'http://localhost:11434/api/generate', [
            'json' => [
                'model' => 'qwen2.5:7b',
                'prompt' => $prompt,
                'stream' => false,
                'options' => [
                    'temperature' => 0.3
                ]
            ],
            'timeout' => 120
        ]);

        $response = $response->toArray();
        return new JsonResponse(["message" => "Success", "response" => @$response["response"]], Response::HTTP_OK);
    }
}
