'use client';

import { useState } from 'react';
import { useAuth } from '@/context/AuthContext';
import Link from 'next/link';
import { EyeIcon, EyeSlashIcon } from '@heroicons/react/24/outline';
import useHandleErrorFields from '@/hooks/useHandleErrorFields';

export default function LoginPage() {
  const { login, fetchingLogin, error, errorsFields, setErrorsFields } = useAuth();
  const [formData, setFormData] = useState({
    email: '',
    password: '',
    remember_me: false
  });
  const [showPassword, setShowPassword] = useState(false);
  const { fieldErrorMessage, fieldHasError, onFocusRemove } = useHandleErrorFields();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await login(formData.email, formData.password, formData.remember_me);
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div className="page-container">
      <div className="form-container">
        <h1 className="form-title">
          Intranet Login
        </h1>
        {error && (
          <div className="error-message">
            {error}
          </div>
        )}
        <form onSubmit={handleSubmit} className="form-space">
          <div>
            <label htmlFor="email" className="label-base">
              Email 
            </label>
            <input
              type="email"
              id="email"
              value={formData.email}
              onChange={(e) => setFormData({ ...formData, email: e.target.value })}
              className={`input-base ${fieldHasError('email', errorsFields) ? 'border-red-500' : ''}`}
              autoComplete="off"
              disabled={fetchingLogin}
              onFocus={() => onFocusRemove('email', errorsFields, setErrorsFields)}
            />
          </div>
          <div className={`error-field ${fieldHasError('email', errorsFields) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('email', errorsFields)}
          </div>
          <div className="password-input-container">
            <label htmlFor="password" className="label-base">
              Contraseña
            </label>
            <div className="relative">
              <input
                type={showPassword ? 'text' : 'password'}
                id="password"
                value={formData.password}
                onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                className={`input-base pr-10 ${fieldHasError('password', errorsFields) ? 'border-red-500' : ''}`}
                autoComplete="new-password"
                disabled={fetchingLogin}
                onFocus={() => onFocusRemove('password', errorsFields, setErrorsFields)}
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 disabled:opacity-50"
                disabled={fetchingLogin}
              >
                {showPassword ? (
                  <EyeSlashIcon className="h-5 w-5" />
                ) : (
                  <EyeIcon className="h-5 w-5" />
                )}
              </button>
            </div>
          </div>
          <div className={`error-field ${fieldHasError('password', errorsFields) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('password', errorsFields)}
          </div>
          <div className="flex items-center">
            <input
              type="checkbox"
              id="remember_me"
              checked={formData.remember_me}
              onChange={(e) => setFormData({ ...formData, remember_me: e.target.checked })}
              className="h-4 w-4 text-slate-600 focus:ring-slate-500 border-slate-300 rounded"
              disabled={fetchingLogin}
            />
            <label htmlFor="remember_me" className="ml-2 block text-sm text-slate-700">
              Recuérdame
            </label>
          </div>
          <button
            type="submit"
            disabled={fetchingLogin}
            className="button-primary"
          >
            {fetchingLogin ? (
              <div className="flex items-center justify-center gap-2">
                <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                Cargando...
              </div>
            ) : (
              'Iniciar Sesión'
            )}
          </button>
        </form>
        <div className="mt-6 text-center">
          <Link href="/register" className="link-base">
            ¿No tienes cuenta? Regístrate
          </Link>
        </div>
      </div>
    </div>
  );
}