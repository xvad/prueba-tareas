'use client';

import { useEffect, useState } from 'react';
import { useAuth } from '@/context/AuthContext';
import Link from 'next/link';
import { EyeIcon, EyeSlashIcon } from '@heroicons/react/24/outline';
import useHandleErrorFields from '@/hooks/useHandleErrorFields';

export default function RegisterPage() {
  const { register, fetchingRegister, error, errorsFields, setErrorsFields, setError } = useAuth();
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const { fieldErrorMessage, fieldHasError, onFocusRemove } = useHandleErrorFields();

  useEffect(() => {
    return () => {
      setErrorsFields({});
      setError('');
    };
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();



    try {
      await register(
        formData.name,
        formData.email,
        formData.password,
        formData.password_confirmation
      );
    } catch {
      console.log('Error en el registro. Por favor, intente nuevamente.');
    }
  };

  return (
    <div className="page-container">
      <div className="form-container">
        <h1 className="form-title">
          Registro
        </h1>
        {error && (
          <div className="error-message">
            {error}
          </div>
        )}
        <form onSubmit={handleSubmit} className="form-space">
          <div>
            <label htmlFor="name" className="label-base">
              Nombre
            </label>
            <input
              type="text"
              id="name"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              className={`input-base ${fieldHasError('name', errorsFields) ? 'border-red-500' : ''}`}
              autoComplete="off"
              disabled={fetchingRegister}
              onFocus={() => onFocusRemove('name', errorsFields, setErrorsFields)}
            />
          </div>
          <div className={`error-field ${fieldHasError('name', errorsFields) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('name', errorsFields)}
          </div>
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
              disabled={fetchingRegister}
              onFocus={() => onFocusRemove('email', errorsFields, setErrorsFields)}
            />
          </div>
          <div className={`error-field ${fieldHasError('email', errorsFields) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('email', errorsFields)}
          </div>
          <div>
            <label htmlFor="password" className="label-base">
              Contraseña
            </label>
            <div className="relative">
              <input
                type={showPassword ? "text" : "password"}
                id="password"
                value={formData.password}
                onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                className={`input-base pr-10 ${fieldHasError('password', errorsFields) ? 'border-red-500' : ''}`}
                autoComplete="new-password"
                disabled={fetchingRegister}
                onFocus={() => onFocusRemove('password', errorsFields, setErrorsFields)}
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 disabled:opacity-50"
                disabled={fetchingRegister}
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
          <div>
            <label htmlFor="password_confirmation" className="label-base">
              Confirmar Contraseña
            </label>
            <div className="relative">
              <input
                type={showConfirmPassword ? "text" : "password"}
                id="password_confirmation"
                value={formData.password_confirmation}
                onChange={(e) => setFormData({ ...formData, password_confirmation: e.target.value })}
                className={`input-base pr-10 ${fieldHasError('password_confirmation', errorsFields) ? 'border-red-500' : ''}`}
                autoComplete="new-password"
                disabled={fetchingRegister}
                onFocus={() => onFocusRemove('password_confirmation', errorsFields, setErrorsFields)}
              />
              <button
                type="button"
                onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 disabled:opacity-50"
                disabled={fetchingRegister}
              >
                {showConfirmPassword ? (
                  <EyeSlashIcon className="h-5 w-5" />
                ) : (
                  <EyeIcon className="h-5 w-5" />
                )}
              </button>
            </div>
          </div>
          <div className={`error-field ${fieldHasError('password_confirmation', errorsFields) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('password_confirmation', errorsFields)}
          </div>
          <button
            type="submit"
            disabled={fetchingRegister}
            className="button-primary"
          >
            {fetchingRegister ? (
              <div className="flex items-center justify-center gap-2">
                <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                Registrando...
              </div>
            ) : (
              'Registrarse'
            )}
          </button>
        </form>
        <div className="mt-6 text-center">
          <Link href="/login" className="link-base">
            ¿Ya tienes cuenta? Inicia sesión
          </Link>
        </div>
      </div>
    </div>
  );
}