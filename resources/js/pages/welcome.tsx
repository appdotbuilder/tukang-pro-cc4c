import React from 'react';
import { type SharedData } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { Craftsman, Skill } from '@/types/craftsman';

interface Props {
    featuredCraftsmen: Craftsman[];
    skills: Skill[];
    stats: {
        total_craftsmen: number;
        total_customers: number;
        completed_jobs: number;
        average_rating: number;
    };
    filters: {
        skill: string | null;
        location: string | null;
    };
    [key: string]: unknown;
}

export default function Welcome({ featuredCraftsmen, skills, stats, filters }: Props) {
    const { auth } = usePage<SharedData>().props;
    const [searchSkill, setSearchSkill] = React.useState(filters.skill || '');
    const [searchLocation, setSearchLocation] = React.useState(filters.location || '');

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('search'), {
            skill: searchSkill,
            location: searchLocation,
        });
    };

    return (
        <>
            <Head title="🔨 Layanan Tukang Tersertifikasi">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="bg-white dark:bg-gray-800 shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center py-4">
                            <div className="flex items-center">
                                <span className="text-2xl font-bold text-blue-600">🔨</span>
                                <span className="ml-2 text-xl font-bold text-gray-900 dark:text-white">CraftsmanApp</span>
                            </div>
                            <nav className="flex items-center gap-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-gray-700 dark:text-gray-300 hover:text-blue-600 px-4 py-2"
                                        >
                                            Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Daftar
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="py-20 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <h1 className="text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            🏠 Layanan Tukang Tersertifikasi
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto">
                            Temukan tukang berpengalaman dan tersertifikasi untuk semua kebutuhan rumah Anda.
                            Mulai dari listrik, pipa, kayu, hingga renovasi besar-besaran.
                        </p>

                        {/* Search Form */}
                        <form onSubmit={handleSearch} className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-4xl mx-auto mb-16">
                            <div className="grid md:grid-cols-3 gap-4 items-end">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        🔧 Jenis Keahlian
                                    </label>
                                    <select
                                        value={searchSkill}
                                        onChange={(e) => setSearchSkill(e.target.value)}
                                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    >
                                        <option value="">Semua keahlian</option>
                                        {skills.map((skill) => (
                                            <option key={skill.id} value={skill.name}>
                                                {skill.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        📍 Lokasi
                                    </label>
                                    <input
                                        type="text"
                                        value={searchLocation}
                                        onChange={(e) => setSearchLocation(e.target.value)}
                                        placeholder="Masukkan kota atau area"
                                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                >
                                    🔍 Cari Tukang
                                </button>
                            </div>
                        </form>

                        {/* Stats */}
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600">{stats.total_craftsmen}</div>
                                <div className="text-gray-600 dark:text-gray-400">👷 Tukang Tersertifikasi</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-green-600">{stats.total_customers}</div>
                                <div className="text-gray-600 dark:text-gray-400">👥 Pelanggan Aktif</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-purple-600">{stats.completed_jobs}</div>
                                <div className="text-gray-600 dark:text-gray-400">✅ Proyek Selesai</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-yellow-600">{stats.average_rating.toFixed(1)}</div>
                                <div className="text-gray-600 dark:text-gray-400">⭐ Rating Rata-rata</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Featured Craftsmen */}
                {featuredCraftsmen.length > 0 && (
                    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
                        <div className="max-w-7xl mx-auto">
                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white text-center mb-12">
                                🌟 Tukang Unggulan
                            </h2>
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {featuredCraftsmen.map((craftsman) => (
                                    <div key={craftsman.id} className="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                        <div className="flex items-center mb-4">
                                            <div className="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                                {craftsman.user.name.charAt(0)}
                                            </div>
                                            <div className="ml-4">
                                                <h3 className="font-semibold text-gray-900 dark:text-white">{craftsman.user.name}</h3>
                                                <div className="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                    <span>⭐ {craftsman.rating}</span>
                                                    <span className="ml-2">({craftsman.total_reviews} ulasan)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <div className="flex flex-wrap gap-2">
                                                {craftsman.skills.slice(0, 3).map((skill, index: number) => (
                                                    <span key={index} className="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                                        {skill.skill.name}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>
                                        <div className="flex justify-between items-center">
                                            <span className="text-lg font-bold text-green-600">
                                                Rp {craftsman.hourly_rate?.toLocaleString('id-ID') || 'TBD'}/jam
                                            </span>
                                            <Link
                                                href={route('craftsmen.show', craftsman.id)}
                                                className="text-blue-600 hover:text-blue-700 font-medium"
                                            >
                                                Lihat Profile →
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </section>
                )}

                {/* How it Works */}
                <section className="py-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-white text-center mb-12">
                            🚀 Cara Kerja Platform
                        </h2>
                        <div className="grid md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                                    🔍
                                </div>
                                <h3 className="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Cari Tukang</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Temukan tukang berdasarkan keahlian dan lokasi yang Anda butuhkan
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                                    💬
                                </div>
                                <h3 className="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Buat Pesanan</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Deskripsikan pekerjaan Anda dan dapatkan penawaran dari tukang
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                                    ✅
                                </div>
                                <h3 className="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Selesai</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Pekerjaan selesai dengan kualitas terjamin dan berikan ulasan
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-blue-600">
                    <div className="max-w-4xl mx-auto text-center">
                        <h2 className="text-3xl font-bold text-white mb-6">
                            Siap Memulai Proyek Anda?
                        </h2>
                        <p className="text-xl text-blue-100 mb-8">
                            Bergabunglah dengan ribuan pelanggan yang telah mempercayakan proyek mereka kepada tukang tersertifikasi kami
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            {!auth.user && (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold"
                                    >
                                        🏠 Daftar sebagai Pelanggan
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="bg-blue-700 text-white px-8 py-3 rounded-lg hover:bg-blue-800 transition-colors font-semibold border-2 border-blue-400"
                                    >
                                        🔨 Daftar sebagai Tukang
                                    </Link>
                                </>
                            )}
                            {auth.user && (
                                <Link
                                    href={route('dashboard')}
                                    className="bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold"
                                >
                                    📊 Ke Dashboard
                                </Link>
                            )}
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-8 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <div className="flex items-center justify-center mb-4">
                            <span className="text-2xl">🔨</span>
                            <span className="ml-2 text-xl font-bold">CraftsmanApp</span>
                        </div>
                        <p className="text-gray-400 mb-4">
                            Platform terpercaya untuk menghubungkan pelanggan dengan tukang tersertifikasi
                        </p>
                        <div className="text-sm text-gray-500">
                            Built with ❤️ by{" "}
                            <a 
                                href="https://app.build" 
                                target="_blank" 
                                className="text-blue-400 hover:underline"
                            >
                                app.build
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}