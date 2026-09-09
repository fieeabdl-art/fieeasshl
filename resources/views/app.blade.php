<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['site_title'] ?? 'Bumiyuji Living'); ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Playfair Display (Luxury Serif) & Plus Jakarta Sans (Modern Sans-serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            forest: '#2C3E35', // Warna Hijau Forest Premium
                            gold: '#C5A880',   // Warna Champagne Gold Elegan
                            cream: '#F9F6F0',  // Warna Background Terang Mewah
                            charcoal: '#1E1E1E'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .custom-gradient {
            background: linear-gradient(135deg, #2C3E35 0%, #15221B 100%);
        }
    </style>
</head>
<body class="font-sans bg-brand-cream text-brand-charcoal antialiased">

    <!-- Top Info Bar -->
    <div class="bg-brand-forest text-brand-gold text-xs py-2 px-4 border-b border-brand-gold/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <?php echo htmlspecialchars($settings['address'] ?? 'Sukabumi, Jawa Barat'); ?>
            </span>
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo htmlspecialchars($settings['office_hours'] ?? 'Senin - Sabtu: 08:00 - 17:00'); ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-brand-forest/5">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#" class="flex flex-col">
                <span class="font-serif text-xl tracking-widest font-bold text-brand-forest leading-none">BUMIYUJI</span>
                <span class="text-[9px] tracking-[0.25em] font-medium text-brand-gold uppercase mt-0.5">L I V I N G</span>
            </a>

            <!-- Desktop Menu Links -->
            <div class="hidden md:flex items-center gap-8 font-medium text-sm text-brand-forest/85">
                <a href="#beranda" class="hover:text-brand-gold transition duration-200">Beranda</a>
                <a href="#tentang" class="hover:text-brand-gold transition duration-200">Tentang Kami</a>
                <a href="#layanan" class="hover:text-brand-gold transition duration-200">Layanan</a>
                <a href="#portofolio" class="hover:text-brand-gold transition duration-200">Portofolio</a>
                <a href="#alur-kerja" class="hover:text-brand-gold transition duration-200">Alur Kerja</a>
                <a href="#kontak" class="hover:text-brand-gold transition duration-200">Hubungi Kami</a>
            </div>

            <!-- CTA Konsultasi Header -->
            <div class="flex items-center gap-4">
                <a href="https://wa.me/<?php echo htmlspecialchars($settings['wa_number'] ?? '6281311114523'); ?>?text=Halo%20Bumiyuji%2C%20saya%20ingin%20berkonsultasi%20mengenai%20desain%20interior." 
                   target="_blank" 
                   class="bg-brand-forest hover:bg-brand-gold text-white hover:text-brand-forest font-semibold text-xs tracking-wider uppercase px-5 py-3 rounded border border-brand-forest hover:border-brand-gold transition-all duration-300 shadow-md">
                    Konsultasi Gratis
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="relative custom-gradient text-white min-h-[85vh] flex items-center justify-center overflow-hidden px-4">
        <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80');"></div>
        
        <div class="relative max-w-5xl mx-auto text-center py-20 px-4">
            <span class="text-brand-gold font-semibold tracking-[0.3em] uppercase text-xs sm:text-sm block mb-4">Interior | Architecture | Contractor</span>
            <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-6">
                <?php echo htmlspecialchars($settings['hero_title'] ?? 'Mewujudkan Ruang Impian Menjadi Nyata'); ?>
            </h1>
            <p class="text-sm sm:text-base md:text-lg text-stone-300 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                <?php echo htmlspecialchars($settings['hero_subtitle'] ?? 'Kami menghadirkan desain interior yang elegan, fungsional, dan berkualitas tinggi.'); ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="#appointment" class="w-full sm:w-auto bg-brand-gold hover:bg-white text-brand-forest font-semibold text-sm tracking-wider uppercase px-8 py-4 rounded transition duration-300 shadow-lg text-center">
                    Buat Janji Temu
                </a>
                <a href="#portofolio" class="w-full sm:w-auto bg-transparent hover:bg-white/10 text-white font-semibold text-sm tracking-wider uppercase px-8 py-4 rounded border border-white/50 transition duration-300 text-center">
                    Lihat Portofolio
                </a>
            </div>
        </div>
    </section>

    <!-- Keunggulan (4 Pilar) -->
    <section class="py-12 bg-white border-b border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-cream flex items-center justify-center text-brand-gold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="font-serif font-semibold text-brand-forest">Garansi Pekerjaan</h3>
                </div>
                <div class="p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-cream flex items-center justify-center text-brand-gold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-serif font-semibold text-brand-forest">Desain Eksklusif</h3>
                </div>
                <div class="p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-cream flex items-center justify-center text-brand-gold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="font-serif font-semibold text-brand-forest">Tim Profesional</h3>
                </div>
                <div class="p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-cream flex items-center justify-center text-brand-gold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="font-serif font-semibold text-brand-forest">Material Berkualitas</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-20 bg-brand-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80" 
                         alt="Bumiyuji Workspace" 
                         class="rounded shadow-2xl relative z-10 w-full object-cover h-[500px]">
                    <div class="absolute -bottom-6 -right-6 w-full h-full border-[6px] border-brand-gold rounded z-0"></div>
                </div>

                <div>
                    <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">TENTANG KAMI</span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-6 leading-tight">
                        <?php echo htmlspecialchars($settings['about_title'] ?? ''); ?>
                    </h2>
                    <p class="text-stone-600 mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($settings['about_text'] ?? ''); ?>
                    </p>
                    <p class="text-stone-600 mb-8 leading-relaxed font-light">
                        <?php echo htmlspecialchars($settings['about_subtext'] ?? ''); ?>
                    </p>

                    <div class="space-y-6">
                        <div class="p-4 bg-white rounded shadow-sm border-l-4 border-brand-gold">
                            <h4 class="font-serif font-semibold text-brand-forest mb-1">Visi Kami</h4>
                            <p class="text-sm text-stone-500 font-light"><?php echo htmlspecialchars($settings['visi'] ?? ''); ?></p>
                        </div>
                        
                        <?php if (!empty($misiList)): ?>
                        <div class="p-4 bg-white rounded shadow-sm border-l-4 border-brand-forest">
                            <h4 class="font-serif font-semibold text-brand-forest mb-2">Misi Kami</h4>
                            <ul class="list-disc pl-4 text-xs sm:text-sm text-stone-500 space-y-1.5">
                                <?php foreach ($misiList as $misiItem): ?>
                                    <?php if (trim($misiItem) !== ''): ?>
                                        <li><?php echo htmlspecialchars(trim($misiItem)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kenapa Harus Bumiyuji -->
    <section class="py-16 bg-white border-t border-b border-stone-100">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">KEUNGGULAN EKSTRA</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-brand-forest mb-12">Kenapa Harus Bumiyuji Interior?</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="p-5 bg-brand-cream rounded shadow-sm flex flex-col items-center">
                    <span class="text-brand-gold font-bold text-lg mb-1">Free</span>
                    <span class="text-xs sm:text-sm text-brand-forest font-semibold">Konsultasi Awal</span>
                </div>
                <div class="p-5 bg-brand-cream rounded shadow-sm flex flex-col items-center">
                    <span class="text-brand-gold font-bold text-lg mb-1">Free</span>
                    <span class="text-xs sm:text-sm text-brand-forest font-semibold">Survei Lokasi</span>
                </div>
                <div class="p-5 bg-brand-cream rounded shadow-sm flex flex-col items-center">
                    <span class="text-brand-gold font-bold text-lg mb-1">Free</span>
                    <span class="text-xs sm:text-sm text-brand-forest font-semibold">Konsep Design Awal</span>
                </div>
                <div class="p-5 bg-brand-cream rounded shadow-sm flex flex-col items-center">
                    <span class="text-brand-gold font-bold text-lg mb-1">Gratis</span>
                    <span class="text-xs sm:text-sm text-brand-forest font-semibold">Revisi Design</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Kami -->
    <section id="layanan" class="py-20 bg-brand-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">LAYANAN KAMI</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">Solusi interior untuk berbagai kebutuhan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=600&q=80" alt="Interior Rumah" class="h-64 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-serif font-bold text-xl text-brand-forest mb-2">Interior Rumah</h3>
                        <p class="text-stone-500 text-sm">Menciptakan kenyamanan hunian premium dengan desain modern elegan.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80" alt="Interior Kantor" class="h-64 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-serif font-bold text-xl text-brand-forest mb-2">Interior Kantor</h3>
                        <p class="text-stone-500 text-sm">Optimalisasi tata ruang kantor fungsional dan representatif.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=600&q=80" alt="Custom Furniture" class="h-64 w-full object-cover">
                    <div class="p-6">
                        <h3 class="font-serif font-bold text-xl text-brand-forest mb-2">Custom Furniture</h3>
                        <p class="text-stone-500 text-sm">Pengerjaan kitchen set, kabinet, dan furnitur presisi tinggi di workshop.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portofolio Section -->
    <section id="portofolio" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">GALERI PROYEK</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">PORTOFOLIO KAMI</h2>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap justify-center items-center gap-2 mb-12" id="portfolio-filters">
                <button class="px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-forest text-white" data-filter="all">Semua</button>
                <button class="px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white" data-filter="Rumah">Rumah</button>
                <button class="px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white" data-filter="Kitchen Set">Kitchen Set</button>
                <button class="px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white" data-filter="Kantor">Kantor</button>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="portfolio-grid">
                <?php if (empty($portfolios)): ?>
                    <p class="col-span-full text-center text-stone-400 py-12">Belum ada portofolio saat ini.</p>
                <?php else: ?>
                    <?php foreach ($portfolios as $p): ?>
                        <div class="portfolio-item bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-all duration-300" data-category="<?php echo htmlspecialchars($p['category']); ?>">
                            <div class="h-64 bg-stone-100 relative overflow-hidden group">
                                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($p['title']); ?>" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=600&q=80'">
                                <div class="absolute top-3 left-3 bg-brand-gold text-brand-forest text-[10px] tracking-wider uppercase font-bold px-2.5 py-1 rounded">
                                    <?php echo htmlspecialchars($p['category']); ?>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-serif font-bold text-lg text-brand-forest mb-1"><?php echo htmlspecialchars($p['title']); ?></h3>
                                <p class="text-stone-500 text-xs sm:text-sm font-light"><?php echo htmlspecialchars($p['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Alur Kerja -->
    <section id="alur-kerja" class="py-20 bg-brand-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">7 LANGKAH TRANSPARAN</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">ALUR KERJA BUMIYUJI</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">01</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">KONSULTASI</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Menghubungi Customer Service atau datang langsung ke kantor kami.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">02</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">SURVEI LOKASI</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Pemetaan, pengukuran, dan survei langsung ke ruangan Anda.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">03</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">DESIGN & RAB</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Pembuatan visualisasi rancangan desain 3D dan kalkulasi anggaran biaya.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">04</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">REVISI</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Sesi penyesuaian detail desain berdasarkan kesepakatan bersama.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">05</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">PRODUKSI</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Pengerjaan di workshop selama kurang lebih 4-8 minggu.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">06</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">INSTALASI</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Pengiriman dan perakitan langsung di lokasi proyek secara presisi.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm relative col-span-1 sm:col-span-2 flex flex-col justify-center">
                    <span class="absolute top-4 right-4 text-brand-gold font-serif text-3xl font-bold">07</span>
                    <h3 class="font-serif font-bold text-brand-forest text-lg mb-2">SERAH TERIMA</h3>
                    <p class="text-stone-500 text-xs sm:text-sm">Serah terima hasil pekerjaan akhir, penyerahan invoice, serta kartu garansi purna jual.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">TESTIMONI</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-brand-forest mb-12">APA KATA KLIEN KAMI</h2>

            <?php if (empty($testimonials)): ?>
                <p class="text-stone-400">Belum ada testimoni klien saat ini.</p>
            <?php else: ?>
                <div class="bg-brand-cream p-8 sm:p-12 rounded shadow-sm relative">
                    <?php foreach ($testimonials as $t): ?>
                        <div class="relative z-10">
                            <p class="text-stone-600 text-sm sm:text-base italic leading-relaxed mb-8">
                                "<?php echo htmlspecialchars($t['content']); ?>"
                            </p>
                            <h4 class="font-bold text-brand-forest text-sm sm:text-base"><?php echo htmlspecialchars($t['name']); ?></h4>
                            <span class="text-xs text-brand-gold font-medium uppercase tracking-wider">
                                <?php echo htmlspecialchars($t['role'] . ' - ' . $t['company']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Book Appointment Form -->
    <section id="appointment" class="py-20 custom-gradient text-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">BOOK APPOINTMENT</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold mb-4">Siap Mewujudkan Interior Impian Anda?</h2>
            </div>

            <form class="space-y-6 bg-white/10 p-8 sm:p-10 rounded-lg backdrop-blur-md" id="appointment-form" onsubmit="handleFormSubmit(event)">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Nama Anda</label>
                        <input type="text" id="form-name" required class="w-full bg-white/15 text-white border border-white/20 rounded px-4 py-3 focus:outline-none" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Nomor HP / WhatsApp</label>
                        <input type="tel" id="form-phone" required class="w-full bg-white/15 text-white border border-white/20 rounded px-4 py-3 focus:outline-none" placeholder="Contoh: 0813...">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Email (Opsional)</label>
                        <input type="email" id="form-email" class="w-full bg-white/15 text-white border border-white/20 rounded px-4 py-3 focus:outline-none" placeholder="Email Anda">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Rencana Project</label>
                        <select id="form-project" required class="w-full bg-white/15 text-stone-200 border border-white/20 rounded px-4 py-3 focus:outline-none">
                            <option value="Interior Rumah" class="text-brand-charcoal">Interior Rumah</option>
                            <option value="Interior Kantor" class="text-brand-charcoal">Interior Kantor</option>
                            <option value="Kitchen Set / Custom Furniture" class="text-brand-charcoal">Kitchen Set / Custom Furniture</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Alamat Lengkap Project</label>
                    <textarea id="form-address" required rows="3" class="w-full bg-white/15 text-white border border-white/20 rounded px-4 py-3 focus:outline-none" placeholder="Tuliskan alamat lengkap..."></textarea>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-200 mb-2">Referensi Foto (Opsional, Maks 1MB, format JPG/PNG)</label>
                    <input type="file" id="form-photo" accept=".jpg,.jpeg,.png" class="w-full text-xs text-stone-300">
                    <span id="file-error" class="text-red-400 text-xs block mt-1 hidden">Ukuran file melebihi 1MB atau format tidak sesuai!</span>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-brand-gold hover:bg-white text-brand-forest font-bold text-sm tracking-wider uppercase py-4 rounded shadow-lg transition duration-300">
                        KIRIM PESAN (Lanjut ke WA)
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-brand-charcoal text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <a href="#" class="flex flex-col mb-4">
                    <span class="font-serif text-2xl tracking-widest font-bold text-white leading-none">BUMIYUJI</span>
                    <span class="text-[10px] tracking-[0.25em] font-medium text-brand-gold uppercase mt-0.5">L I V I N G</span>
                </a>
                <p class="text-stone-400 text-xs sm:text-sm">Mewujudkan ruang impian Anda menjadi kenyataan di Sukabumi, Jawa Barat.</p>
                <div class="text-xs text-stone-500 mt-4">
                    <a href="login.php" class="text-brand-gold hover:underline">🔐 Login Dashboard Admin</a>
                </div>
            </div>

            <div>
                <h4 class="font-serif font-bold text-lg text-brand-gold mb-6 uppercase">Contact Us</h4>
                <ul class="space-y-4 text-xs sm:text-sm text-stone-300">
                    <li>Alamat: <?php echo htmlspecialchars($settings['address'] ?? ''); ?></li>
                    <li>WhatsApp: +<?php echo htmlspecialchars($settings['wa_number'] ?? ''); ?></li>
                    <li>Email: <?php echo htmlspecialchars($settings['email'] ?? ''); ?></li>
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-lg text-brand-gold mb-6 uppercase">Social Media</h4>
                <p class="text-stone-400 text-xs">Instagram: <?php echo htmlspecialchars($settings['instagram'] ?? ''); ?></p>
            </div>
        </div>

        <div class="border-t border-stone-800 pt-8 text-center text-xs text-stone-500">
            &copy; 2026 Bumiyuji Living. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

    <script>
        // Filters
        const filterButtons = document.querySelectorAll('#portfolio-filters button');
        const portfolioItems = document.querySelectorAll('#portfolio-grid .portfolio-item');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('bg-brand-forest', 'text-white'));
                btn.classList.add('bg-brand-forest', 'text-white');

                const filterVal = btn.getAttribute('data-filter');

                portfolioItems.forEach(item => {
                    if (filterVal === 'all' || item.getAttribute('data-category') === filterVal) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });

        // Form Submit
        function handleFormSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('form-name').value;
            const phone = document.getElementById('form-phone').value;
            const email = document.getElementById('form-email').value || '-';
            const address = document.getElementById('form-address').value;
            const project = document.getElementById('form-project').value;
            
            let waText = "Halo Bumiyuji Living,\n";
            waText += "Saya ingin menjadwalkan janji temu konsultasi:\n\n";
            waText += "*Nama:* " + name + "\n";
            waText += "*No. HP/WA:* " + phone + "\n";
            waText += "*Email:* " + email + "\n";
            waText += "*Alamat Proyek:* " + address + "\n";
            waText += "*Rencana Project:* " + project + "\n";
            
            const encodedText = encodeURIComponent(waText);
            const waNumber = "<?php echo $settings['wa_number'] ?? '6281311114523'; ?>";
            
            window.open("https://wa.me/" + waNumber + "?text=" + encodedText, '_blank');
        }
    </script>
</body>
</html>