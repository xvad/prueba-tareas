'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { deleteCookie } from 'cookies-next';
import { useAuth } from '@/context/AuthContext';

export default function IntranetLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const router = useRouter();
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const { user } = useAuth();
  const handleLogout = () => {
    deleteCookie('token');
    deleteCookie('rememberMe');
    window.location.href ='/login';
  };

  return (
    <div className="min-h-screen bg-gray-100">
      {/* Navbar */}
      <nav className="bg-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              <div className="flex-shrink-0">
                <h1 className="text-xl font-bold text-gray-800">{user?.name ? `Bienvenido ${user?.name}` : 'Bienvenido'}</h1>
              </div>
              <div className="hidden md:block ml-6">
                <div className="flex items-center space-x-4">
                  {/* <Link href="/intranet" className="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    Inicio
                  </Link> */}
                </div>
              </div>
            </div>
            <div className="flex items-center">
              <button
                onClick={handleLogout}
                className="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors"
              >
                Cerrar Sesión
              </button>
            </div>
          </div>
        </div>
      </nav>

      {/* Main Content */}
      <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <main className="px-4 py-6 sm:px-0">
          {children}
        </main>
      </div>
    </div>
  );
} 