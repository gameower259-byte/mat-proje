<?php

declare(strict_types=1);

function getCategory(int $year): string
{
    if ($year < -300) {
        return 'Antik Uygarlıklar';
    }
    if ($year < 600) {
        return 'Antik Yunan / Roma';
    }
    if ($year < 1500) {
        return 'Orta Çağ / İslam Dünyası';
    }
    if ($year < 1800) {
        return 'Rönesans ve Aydınlanma';
    }
    if ($year < 1950) {
        return 'Modern Matematik';
    }

    return 'Çağdaş Matematik';
}

function getPortalData(): array
{
    $events = [
        [
            'title' => 'Pisagor Teoremi Gelişimi',
            'summary' => 'Dik üçgenlerde kenar ilişkileri üzerine yapılan çalışmaların tarihsel çizgisi.',
            'formula' => 'a^2 + b^2 = c^2',
            'article' => 'Pisagor Teoremi: Tarihsel Doğuş, İspat Yöntemleri ve Modern Uygulamalar',
            'source' => 'Antik Matematik Kayıtları',
            'article_detail' => 'Bu çalışma, Pisagor teoreminin Mezopotamya tabletlerinden Antik Yunan okullarına kadar uzanan gelişimini incelemektedir. Teoremin farklı kültürlerdeki ispat teknikleri, geometri öğretimi üzerindeki etkisi ve günümüz mühendislik problemlerinde nasıl kullanıldığı ayrıntılı örneklerle açıklanır.',
            'formula_steps' => [
                'Dik üçgeni tanımla ve dik kenarları a, b; hipotenüsü c olarak adlandır.',
                'Dik kenarların karelerini hesapla: a² ve b².',
                'Bu iki değeri topla: a² + b².',
                'Toplamın karekökünü alarak hipotenüsü bul: c = √(a²+b²).',
            ],
        ],
        [
            'title' => 'Asal Sayı Araştırmaları',
            'summary' => 'Asal sayıların dağılımı ve sayı teorisinde merkezi rolü.',
            'formula' => '\\pi(x) \\sim \\frac{x}{\\ln x}',
            'article' => 'Asal Sayıların Dağılımı ve Kriptografiye Etkileri',
            'source' => 'Sayı Teorisi Arşivi',
            'article_detail' => 'Asal sayılar, hem teorik matematiğin hem de modern dijital güvenliğin temel taşlarıdır. Makale, asal sayı teoremini, dağılım tahmin yöntemlerini ve büyük asal sayıların kriptografide neden kritik olduğunu açıklamaktadır.',
            'formula_steps' => [
                'π(x), x değerine kadar olan asal sayı adedini ifade eder.',
                'x/ln(x), asal sayıların yaklaşık dağılım modelini verir.',
                'x büyüdükçe π(x) ile x/ln(x) oranı 1’e yaklaşır.',
                'Bu yaklaşım, asal sayı yoğunluğunu büyük aralıklarda tahmin etmede kullanılır.',
            ],
        ],
        [
            'title' => 'Türev Kavramı',
            'summary' => 'Değişim oranı ve diferansiyel hesapta temel kurallar.',
            'formula' => '\\frac{d}{dx}x^n = nx^{n-1}',
            'article' => 'Türev Kurallarının Gelişimi ve Uygulama Alanları',
            'source' => 'Analiz Tarihi',
            'article_detail' => 'Newton ve Leibniz ile sistemleşen türev kavramı, hareket problemlerinden optimizasyona kadar geniş bir kullanım alanına sahiptir. Bu makalede kuvvet kuralı, teğet eğimi, anlık değişim ve modelleme örnekleri adım adım ele alınır.',
            'formula_steps' => [
                'Fonksiyonun kuvvetini (n) belirle.',
                'Katsayı olarak n değerini başa yaz.',
                'Üssü bir azalt: n-1.',
                'Yeni türev ifadesini düzenle: n*x^(n-1).',
            ],
        ],
        [
            'title' => 'İntegral Hesap',
            'summary' => 'Alan hesaplama ve birikim problemleri için integral yaklaşımı.',
            'formula' => '\\int_a^b f(x)dx',
            'article' => 'İntegral Hesabın Teorik Temelleri ve Uygulamalı Örnekler',
            'source' => 'Kalkülüs Arşivi',
            'article_detail' => 'İntegral, birikimli değişimin matematiksel ifadesidir. Makalede belirli integralin geometrik anlamı, Riemann toplamları, temel teorem ve fizik-ekonomi uygulamaları kapsamlı biçimde ele alınmaktadır.',
            'formula_steps' => [
                'İntegral sınırlarını belirle: alt sınır a, üst sınır b.',
                'f(x) fonksiyonunun antitürevini F(x) olarak bul.',
                'Temel teoremi uygula: F(b) - F(a).',
                'Elde edilen sonuç, [a,b] aralığındaki net alan/birikim değeridir.',
            ],
        ],
    ];

    $problems = [
        [
            'title' => 'Pisagor Uygulaması',
            'level' => 7,
            'description' => 'Bir okul bahçesinde dik üçgen şeklinde bir çiçeklik tasarlanıyor. Dik kenarlar 9m ve 12m ise çapraz destek uzunluğu kaç metredir?',
            'detail' => 'Bu problemde amaç, gerçek hayat bağlamında Pisagor teoremini kullanmaktır. Öğrenci önce şekli bir dik üçgen olarak modellemeli, ardından kenarların karelerini hesaplayıp toplamın karekökünü almalıdır. Birim dönüşümü gerekmiyorsa sonuç metre cinsinden bırakılır. Sonuç yorumlanırken fiziksel anlamı da belirtilmelidir: bulunan değer çapraz destek çubuğunun minimum uzunluğunu temsil eder.',
            'steps' => [
                'Verilenleri yaz: a=9, b=12.',
                'Kareleri al: 9²=81, 12²=144.',
                'Topla: 81+144=225.',
                'Karekök al: c=√225=15.',
                'Sonuç: Çapraz destek 15 metredir.',
            ],
        ],
        [
            'title' => 'Asal Sayı Filtreleme',
            'level' => 8,
            'description' => '1 ile 100 arasındaki asal sayıları bulun ve bunlardan iki basamaklı olanların toplamını hesaplayın.',
            'detail' => 'Bu problem, asal sayı tanımının uygulanması ve sistematik tarama becerisini ölçer. Öğrenci önce 1’in asal olmadığını not etmeli, ardından bölen kontrolüyle asalları ayıklamalıdır. İki basamaklı asallar ayrı bir listede toplanıp aritmetik toplam yapılır.',
            'steps' => [
                '1-100 aralığını yaz ve 1’i ele.',
                'Her sayı için 1 ve kendisi dışındaki bölen kontrolü yap.',
                'İki basamaklı asalları listele: 11,13,17,19,...,97.',
                'Listedeki sayıları topla.',
                'Sonucu doğrulamak için ikinci kez kontrol et.',
            ],
        ],
        [
            'title' => 'Fonksiyon Analizi',
            'level' => 10,
            'description' => 'f(x)=x^2-6x+8 fonksiyonunun tepe noktasını ve minimum değerini bulun.',
            'detail' => 'İkinci dereceden fonksiyonlarda tepe noktası analizi, grafik yorumlamanın temelidir. Öğrenci katsayılardan tepe noktası formülünü uygulayarak x koordinatını bulmalı, sonra fonksiyonda yerine koyarak minimum değeri elde etmelidir.',
            'steps' => [
                'a=1, b=-6 olarak belirle.',
                'Tepe noktası x değeri: -b/(2a)=6/2=3.',
                'f(3)=9-18+8=-1 hesapla.',
                'Tepe noktası (3,-1) ve minimum değer -1.',
            ],
        ],
    ];

    $projects = [
        [
            'title' => 'Matematik Tarihi Dijital Sergisi',
            'level' => 8,
            'description' => 'Öğrenciler dönemlere göre matematiksel buluşları seçip etkileşimli bir dijital sergi hazırlar.',
            'detail' => 'Bu proje, araştırma, kaynak değerlendirme ve dijital anlatım becerilerini birleştirir. Her grup bir dönem seçer; bilim insanı, formül ve uygulama örnekleriyle bir bölüm oluşturur. Proje sonunda kaynakça doğruluğu, tarihsel tutarlılık ve görsel anlatım kriterlerine göre değerlendirme yapılır.',
            'deliverables' => [
                'En az 8 olaydan oluşan kronolojik akış',
                'Her olay için en az 1 görsel ve 1 kaynak',
                'Sunum dosyası + kısa rapor',
            ],
        ],
        [
            'title' => 'Kriptografi Mini Laboratuvarı',
            'level' => 11,
            'description' => 'Basit şifreleme yöntemleri ile modüler aritmetiği ilişkilendiren sınıf içi uygulama.',
            'detail' => 'Proje kapsamında öğrenciler Caesar, affine ve temel RSA mantığını karşılaştırır. Her yöntem için matematiksel model kurulur, örnek mesajlar şifrelenir/çözülür ve güvenlik zayıflıkları tartışılır. Amaç, kuramsal matematiği gerçek dünyadaki veri güvenliğiyle bağlamaktır.',
            'deliverables' => [
                'Şifreleme algoritmalarının formül özeti',
                'En az 3 örnek mesajın çözüm adımları',
                'Güvenlik analizi ve sonuç sunumu',
            ],
        ],
    ];

    $scientists = [
        [
            'name' => 'Öklid',
            'era' => 'Antik Yunan',
            'specialty' => 'Geometri',
            'photo' => 'https://upload.wikimedia.org/wikipedia/commons/5/50/Euclid.jpg',
            'detail' => 'Öklid, geometriyi aksiyomatik sistemle kurumsallaştırmıştır. Elementler adlı eseri, yüzyıllarca dünyanın pek çok bölgesinde temel ders kitabı olarak kullanılmıştır.',
        ],
        [
            'name' => 'El-Harezmi',
            'era' => 'İslam Altın Çağı',
            'specialty' => 'Cebir',
            'photo' => 'https://upload.wikimedia.org/wikipedia/commons/3/3b/Al-Khwarizmi-798-850.jpg',
            'detail' => 'El-Harezmi, cebirsel yöntemleri sistemli hale getirerek denklem çözümünde yeni bir dönem başlatmıştır. Algoritma kavramına ilham veren yaklaşımı modern hesaplamanın temel taşlarındandır.',
        ],
    ];

    $timeline = [];
    for ($year = -800; $year <= 2025; $year += 5) {
        $event = $events[array_rand($events)];
        $level = 5 + (abs($year) % 8);
        $timeline[] = [
            'year' => $year,
            'category' => getCategory($year),
            'title' => sprintf('%d %s - %s', abs($year), $year < 0 ? 'MÖ' : 'MS', $event['title']),
            'summary' => sprintf('%s %d yılında matematiksel gelişme: %s', $year < 0 ? 'MÖ' : 'MS', abs($year), $event['summary']),
            'formula' => $event['formula'],
            'formula_steps' => $event['formula_steps'],
            'article' => $event['article'],
            'article_detail' => $event['article_detail'],
            'source' => $event['source'],
            'level' => $level,
        ];
    }

    $bibliography = [];
    foreach ($timeline as $item) {
        $bibliography[] = [
            'source' => $item['source'],
            'article' => $item['article'],
            'year' => $item['year'],
        ];
    }

    return [
        'timeline' => $timeline,
        'problems' => $problems,
        'projects' => $projects,
        'scientists' => $scientists,
        'bibliography' => $bibliography,
    ];
}
