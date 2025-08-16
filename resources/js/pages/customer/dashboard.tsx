import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head, Link } from '@inertiajs/react';

export default function CustomerDashboard() {
    return (
        <>
            <Head title="Customer Dashboard" />
            <AppShell>
                <div className="p-6">
                    <div className="mb-6">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            👋 Selamat Datang, Pelanggan!
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola permintaan layanan dan temukan tukang terbaik untuk proyek Anda
                        </p>
                    </div>

                    {/* Quick Actions */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <Link
                            href="/customer/service-requests/create"
                            className="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6 hover:shadow-md transition-shadow"
                        >
                            <div className="text-blue-600 dark:text-blue-400 text-3xl mb-3">🔧</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Buat Permintaan Baru
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Deskripsikan pekerjaan yang Anda butuhkan
                            </p>
                        </Link>

                        <Link
                            href="/customer/service-requests"
                            className="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6 hover:shadow-md transition-shadow"
                        >
                            <div className="text-green-600 dark:text-green-400 text-3xl mb-3">📋</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Permintaan Saya
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Lihat status semua permintaan layanan
                            </p>
                        </Link>

                        <Link
                            href="/search"
                            className="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-6 hover:shadow-md transition-shadow"
                        >
                            <div className="text-purple-600 dark:text-purple-400 text-3xl mb-3">🔍</div>
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Cari Tukang
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Temukan tukang berdasarkan keahlian
                            </p>
                        </Link>
                    </div>

                    {/* Recent Activity Placeholder */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            📊 Aktivitas Terbaru
                        </h2>
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">📦</div>
                            <p className="text-gray-600 dark:text-gray-400">
                                Belum ada aktivitas. Mulai dengan membuat permintaan layanan pertama Anda!
                            </p>
                        </div>
                    </div>
                </div>
            </AppShell>
        </>
    );
}