import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head, Link, router } from '@inertiajs/react';
import { Craftsman, Skill } from '@/types/craftsman';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    craftsmen: {
        data: Craftsman[];
        links: PaginationLink[];
        meta: {
            total: number;
            current_page: number;
            last_page: number;
        };
    };
    skills: Skill[];
    filters: {
        skill: string | null;
        location: string | null;
        rating: number;
    };
    [key: string]: unknown;
}

export default function Search({ craftsmen, skills, filters }: Props) {
    const [searchSkill, setSearchSkill] = React.useState(filters.skill || '');
    const [searchLocation, setSearchLocation] = React.useState(filters.location || '');
    const [minRating, setMinRating] = React.useState(filters.rating || 0);

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('search'), {
            skill: searchSkill,
            location: searchLocation,
            rating: minRating,
        });
    };

    const clearFilters = () => {
        setSearchSkill('');
        setSearchLocation('');
        setMinRating(0);
        router.get(route('search'));
    };

    return (
        <>
            <Head title="Cari Tukang" />
            <AppShell>
                <div className="p-6">
                    <div className="mb-6">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            🔍 Cari Tukang Tersertifikasi
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Temukan tukang terbaik berdasarkan keahlian dan lokasi
                        </p>
                    </div>

                    {/* Search Form */}
                    <form onSubmit={handleSearch} className="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                        <div className="grid md:grid-cols-4 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🔧 Keahlian
                                </label>
                                <select
                                    value={searchSkill}
                                    onChange={(e) => setSearchSkill(e.target.value)}
                                    className="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700"
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
                                    placeholder="Kota atau area"
                                    className="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    ⭐ Rating Minimum
                                </label>
                                <select
                                    value={minRating}
                                    onChange={(e) => setMinRating(Number(e.target.value))}
                                    className="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700"
                                >
                                    <option value={0}>Semua rating</option>
                                    <option value={4}>4+ ⭐</option>
                                    <option value={4.5}>4.5+ ⭐</option>
                                    <option value={5}>5 ⭐</option>
                                </select>
                            </div>
                            <div className="flex gap-2">
                                <button
                                    type="submit"
                                    className="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                >
                                    Cari
                                </button>
                                <button
                                    type="button"
                                    onClick={clearFilters}
                                    className="px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>

                    {/* Results */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div className="flex justify-between items-center">
                                <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                    Hasil Pencarian
                                </h2>
                                <span className="text-sm text-gray-600 dark:text-gray-400">
                                    {craftsmen.meta.total} tukang ditemukan
                                </span>
                            </div>
                        </div>

                        {craftsmen.data.length > 0 ? (
                            <div className="p-6">
                                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    {craftsmen.data.map((craftsman) => (
                                        <div key={craftsman.id} className="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-shadow">
                                            <div className="flex items-center mb-4">
                                                <div className="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                                    {craftsman.user.name.charAt(0)}
                                                </div>
                                                <div className="ml-4">
                                                    <h3 className="font-semibold text-gray-900 dark:text-white">
                                                        {craftsman.user.name}
                                                    </h3>
                                                    <div className="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                        <span>⭐ {craftsman.rating}</span>
                                                        <span className="ml-2">({craftsman.total_reviews} ulasan)</span>
                                                        {craftsman.is_verified && (
                                                            <span className="ml-2 text-green-600">✓ Terverifikasi</span>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div className="mb-4">
                                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                    📍 {craftsman.location}
                                                </p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                    🛠️ {craftsman.years_experience} tahun pengalaman
                                                </p>
                                                
                                                <div className="flex flex-wrap gap-2 mb-3">
                                                    {craftsman.skills.slice(0, 3).map((skill, index: number) => (
                                                        <span key={index} className="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded text-xs">
                                                            {skill.skill.name}
                                                        </span>
                                                    ))}
                                                    {craftsman.skills.length > 3 && (
                                                        <span className="text-xs text-gray-500">
                                                            +{craftsman.skills.length - 3} lainnya
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                            
                                            <div className="flex justify-between items-center">
                                                <span className="text-lg font-bold text-green-600">
                                                    Rp {craftsman.hourly_rate?.toLocaleString('id-ID') || 'TBD'}/jam
                                                </span>
                                                <Link
                                                    href={route('craftsmen.show', craftsman.id)}
                                                    className="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                                >
                                                    Lihat Detail →
                                                </Link>
                                            </div>
                                        </div>
                                    ))}
                                </div>

                                {/* Pagination */}
                                {craftsmen.links.length > 3 && (
                                    <div className="mt-6 flex justify-center">
                                        <div className="flex gap-1">
                                            {craftsmen.links.map((link, index) => (
                                                <Link
                                                    key={index}
                                                    href={link.url || '#'}
                                                    className={`px-3 py-2 text-sm rounded ${
                                                        link.active
                                                            ? 'bg-blue-600 text-white'
                                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                                                    }`}
                                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                                />
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>
                        ) : (
                            <div className="p-12 text-center">
                                <div className="text-6xl mb-4">🔍</div>
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    Tidak ada tukang yang ditemukan
                                </h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Coba ubah filter pencarian atau lokasi Anda
                                </p>
                            </div>
                        )}
                    </div>
                </div>
            </AppShell>
        </>
    );
}