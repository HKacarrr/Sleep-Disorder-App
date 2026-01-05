<?php

namespace App\Service\Agent\SleepDisorder\Trait;

use App\Service\Agent\TextEditor\TextEditorAgentService;
use App\Service\Dataset\SleepHealth\SleepHealthDatasetService;
use App\Service\NLP\PreProcessing\NlpPreProcessingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait PrivateFunctionProviderTrait
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getSleepHealthDatasetService(): SleepHealthDatasetService
    {
        return $this->container->get(SleepHealthDatasetService::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getTextEditorAgentService(): TextEditorAgentService
    {
        return $this->container->get(TextEditorAgentService::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getNlpPreProcessingService(): NlpPreProcessingService
    {
        return $this->container->get(NlpPreProcessingService::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getPrompt(): string
    {
        $csvContent =  $this->getSleepHealthDatasetService()->getDataset();
        return <<<EOT
            Sen uzman bir Uyku Bilimcisi ve Psikologsun

            ### 1. REFERANS VERİ SETİ (CSV):
            $csvContent

            ### 2. KULLANICI PROFİLİ:
            - Cinsiyet: $this->gender(Male ise Erkek, Female ise Kadın yaz) | Yaş: $this->age | Meslek: $this->job
            - Uyku Süresi: $this->sleepDuration saat | Gece Uyanma Sayısı: $this->nightAwakenings
            - Yaşam Tarzı: $this->lifeDescription

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
            B) BİLİŞSEL YÜK: $this->lifeDescription ve diğe bilgileri tartış.
            C) SONUÇ: Girilen bilgilere göre gerçek bir analiz yap. Girilen bilgiler : $this->gender, $this->age, $this->job, $this->sleepDuration, $this->nightAwakenings, $this->lifeDescription. Ayrıca kullanıcı $this->lifeDescription içinde
            bazı belirtiler girmişse bir hastalık tahmini de yapabilirsin(Hastalığı o belirtilere göre yap lütfen) Belirtilere göre hastalıkları "Uyku Bozukluğu Hastalıkları ve Belirtileri" kısmındaki bilgilerden
            yararlanabilirsin. Ayrıca sonuçların referans noktası her zaman CSV içerisindeki örnekler olmalı. Eğer ki kullanıcı herhangi bir belirti belirtmemişse bir hastalık ile bağdaştırma

            ### NOTES
            **Öznel kalite 10 üzerinden değerlendiriliyor. Yani 0-3 arası kötü, 3-7 arası orta, 7-10 arası da iyi uyku kalitesi olarak adlandırılabilir. Yorumlama yaparken bunlara dikkat et.
            **Kullanıcı Verileri:** cevap içerisinde kesinlikle dönmeli. Her değer alt alta gelmeli. Cinsiyet: ... <br> Yaş: ... <br> gibi tüm değerler dönmeli.
            **CSV Grupları:** cevap içerisinde kesinlik dönmesin
            **Kullanıcın verileri ile CSV içindeki kullanıcıları karşılaştırıp kullanıcının verilerine uygun bir uyku bozukluğu tahmini yap. Kullanıcın verileri ile ortalama olarak eşleştirip CSV içindeki bir hastalığı verebilirsin.
            **Kiymetli Kullanıcı'nın** diye bir şey kesinlikle yazmasın. Kullanıcın yazabilir veya daha profesyone lbir kelime kullanabilirsin
            **Kiymetli Kullanıcı'nın Verileri ile CSV Grubu Kıyaslaması:** bu bölüm kesinlik olmasın. Bunun yerine genel bir değerlendirme yap.
            **Cevaplarda D) Sonuç gibi başlıklar olmasın. SAdece Sonuç olabilir veya Bilişsel yük gibi. aynı şekilde 2. Kullanıcı profili gibi yazmasın. SAdece Kullanıcı Profile yazabilir.
            **Cevaplar HTML formatında dönsün. Fakat **```html** bu değerler olmasın cevapta. Örnepin başlıklar <b>Kullanıcı Profili</b> gibi dönsün. Başlıkların cevapları da div tagı içinde dönebilir. Ayrıca boşluk gerekiyorsa br ekleyebilirsin
            **A) VERİSEL KIYAS: - B) ALGILANAN VS. GERÇEK - C) BİLİŞSEL YÜK: - D) SONUÇ: cevapları sonrası <br><br> tagını koymayı unutma. <br><br> tagları cevaplardan sonra eklenmeli başlıktan sonra değil.
            ** Son olarak kullanıcıya birkaç tavsiye verilebilir.
            ** Cevaplarsa anlatım bozukluğu olmasın. Akıcı ve anlaşılır bir dil kullan. Ayrıca yazım yanlışlarına da dikkat et.
        EOT;
    }
}
