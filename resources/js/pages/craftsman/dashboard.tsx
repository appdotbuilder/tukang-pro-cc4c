import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head, Link } from '@inertiajs/react';

export default function CraftsmanDashboard() {
    return (
        <>
            <Head title="Craftsman Dashboard" />
            <AppShell>
                <div className="p-6">
                    <div className="mb-6">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            🔨 Dashboard Tukang
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola profil dan layanan Anda sebagai tukang tersertifikasi
                        </p>
                    </div>

                    {/* Quick Actions */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <Link
                            href="/craftsman/profile/create"
                            className="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6 hover:shadow-md transition-shadow"
                        >
                            <div className="text-blue-600 dark:text-blue-400 text-3xl mb-3">👤</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Buat Profil
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Lengkapi profil tukang Anda
                            </p>
                        </Link>

                        <div className="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6">
                            <div className="text-green-600 dark:text-green-400 text-3xl mb-3">📋</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Pesanan Masuk
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                0 pesanan baru menunggu
                            </p>
                        </div>

                        <div className="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-6">
                            <div className="text-purple-600 dark:text-purple-400 text-3xl mb-3">⭐</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Rating Saya
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Belum ada rating
                            </p>
                        </div>
                    </div>

                    {/* Stats Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                            <div className="text-2xl font-bold text-blue-600">0</div>
                            <div className="text-sm text-gray-600 dark:text-gray-400">Proyek Aktif</div>
                        </div>
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                            <div className="text-2xl font-bold text-green-600">0</div>
                            <div className="text-sm text-gray-600 dark:text-gray-400">Proyek Selesai</div>
                        </div>
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                            <div className="text-2xl font-bold text-purple-600">0.0</div>
                            <div className="text-sm text-gray-600 dark:text-gray-400">Rating Rata-rata</div>
                        </div>
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                            <div className="text-2xl font-bold text-yellow-600">Rp 0</div>
                            <div className="text-sm text-gray-600 dark:text-gray-400">Pendapatan Bulan Ini</div>
                        </div>
                    </div>

                    {/* Profile Setup Guide */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            🚀 Mulai Sebagai Tukang
                        </h2>
                        <div className="space-y-4">
                            <div className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div className="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    1
                                </div>
                                <div className="ml-4 flex-1">
                                    <h3 className="text-sm font-medium text-gray-900 dark:text-white">
                                        Lengkapi Profil
                                    </h3>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Buat profil dengan bio, keahlian, dan sertifikat Anda
                                    </p>
                                </div>
                                <Link
                                    href="/craftsman/profile/create"
                                    className="ml-4 text-blue-600 hover:text-blue-700 text-sm font-medium"
                                >
                                    Buat Profil →
                                </Link>
                            </div>
                            <div className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg opacity-50">
                                <div className="flex-shrink-0 w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    2
                                </div>
                                <div className="ml-4 flex-1">
                                    <h3 className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Verifikasi Akun
                                    </h3>
                                    <p className="text-sm text-gray-500 dark:text-gray-500">
                                        Tunggu admin memverifikasi profil dan sertifikat Anda
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg opacity-50">
                                <div className="flex-shrink-0 w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    3
                                </div>
                                <div className="ml-4 flex-1">
                                    <h3 className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Terima Pesanan
                                    </h3>
                                    <p className="text-sm text-gray-500 dark:text-gray-500">
                                        Mulai terima dan kerjakan pesanan dari pelanggan
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AppShell>
        </>
    );
}