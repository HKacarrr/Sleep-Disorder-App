# 🎯 Symfony Projesi - Kurulum ve Çalıştırma Rehberi

Bu doküman, Symfony projesinin lokal ortamda kurulumu ve çalıştırılması için gerekli adımları içermektedir.

---

## 📋 İçindekiler

- [Projeyi Çalıştırma](#-projeyi-çalıştırma)
- [Proje Konumu](#️-proje-konumu)
- [AI Modelleri](#-ai-modelleri)
- [Gereksinimler](#-gereksinimler)
- [Sorun Giderme](#-sorun-giderme)

---

## 🚀 Projeyi Çalıştırma

Projeyi başlatmak için aşağıdaki adımları takip edin:

1. Proje dizinine gidin:
```bash
cd proje-dizini
```

2. Symfony yerel sunucusunu başlatın:
```bash
symfony server:start
```

3. Tarayıcınızda `http://localhost:8000` adresine gidin.

---

## 🗂️ Proje Konumu

> ⚠️ **Önemli:** Bu projenin doğru çalışabilmesi için local server dizini altına yerleştirilmesi gerekmektedir.

### Desteklenen Local Server Araçları

| Araç | Dizin |
|------|-------|
| **MAMP** | `MAMP/htdocs/` |
| **XAMPP** | `xampp/htdocs/` |
| **Laragon** | `laragon/www/` |
| **WAMP** | `wamp/www/` |

**Örnek:**
```
MAMP/htdocs/symfony-projesi/
```

---

## 🤖 AI Modelleri

Projede iki farklı AI modeli kullanılmaktadır:

### 1️⃣ Uyku Analizi Modeli ✅ **(Aktif)**

Bu model **aktif olarak** çalışmaktadır ve uyku analizi fonksiyonları için gereklidir.

**Başlatma Komutu:**
```bash
ollama run qwen2.5:7b
```

> 🔴 **Zorunlu:** Bu komut projenin düzgün çalışması için mutlaka çalıştırılmalıdır.

---

### 2️⃣ Text Editör AI Modeli ⏸️ **(Pasif)**

Bu model şu anda **devre dışı** bırakılmıştır ancak gelecekte kullanılmak üzere hazır tutulmaktadır.

**Başlatma Komutu:**
```bash
ollama run llama3.1:8b
```

> ℹ️ **Opsiyonel:** Şu an için bu modelin çalıştırılmasına gerek yoktur.

---

## 📦 Gereksinimler

Projenin çalışması için aşağıdaki gereksinimlerin karşılanması gerekmektedir:

- ✅ PHP 8.1 veya üzeri
- ✅ Composer
- ✅ Symfony CLI
- ✅ Ollama (AI modelleri için)
- ✅ Local Server (MAMP, XAMPP, Laragon vb.)

### Ollama Kurulumu

Ollama'yı sisteminize kurmak için:

```bash
# macOS / Linux
curl -fsSL https://ollama.ai/install.sh | sh

# Windows
# https://ollama.ai/download adresinden indirin
```

---

## 🛠️ Sorun Giderme

### Port Çakışması

Eğer port kullanımda hatası alırsanız:
```bash
symfony server:start --port=8001
```

### AI Modeli Hatası

Ollama servisinin çalıştığından emin olun:
```bash
ollama list
```

### Bağımlılık Hataları

Composer bağımlılıklarını yeniden yükleyin:
```bash
composer install
```

---

## 📝 Özet Checklist

Projeyi çalıştırmadan önce kontrol edin:

- [ ] Proje local server dizini altında
- [ ] Symfony server başlatıldı
- [ ] `qwen2.5:7b` modeli çalıştırıldı
- [ ] Gerekli portlar açık
- [ ] Composer bağımlılıkları yüklü

---

## 📞 Destek

Herhangi bir sorunla karşılaşırsanız:

1. Proje konfigürasyon dosyalarını kontrol edin
2. Log dosyalarını inceleyin (`var/log/`)
3. Gerekli servislerin çalıştığından emin olun

---

<div align="center">

**Geliştirici Notları:** Bu proje Symfony framework'ü ve Ollama AI modelleri kullanılarak geliştirilmiştir.

*Son Güncelleme: 2025*

</div>
