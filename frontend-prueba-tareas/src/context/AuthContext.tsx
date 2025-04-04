'use client';

import { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { useRouter } from 'next/navigation';
import useAuthService from '@/hooks/useAuthService';
import { getCookie, setCookie } from 'cookies-next';

interface User {
  id: number;
  name: string;
  email: string;
}

interface AuthContextType {
  user: User | null;
  isAuthenticated: boolean;
  login: (email: string, password: string, remember_me: boolean) => Promise<void>;
  logout: () => Promise<void>;
  register: (name: string, email: string, password: string, password_confirmation: string) => Promise<void>;
  loading: boolean;
  fetchingLogin: boolean;
  fetchingRegister: boolean;
  fetchingLogout: boolean;
  fetchingMe: boolean;
  error: string;
  errorsFields: object;
  setErrorsFields: (errors: object) => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(true);
  const router = useRouter();
  const {
    login: loginService,
    logout: logoutService,
    register: registerService,
    me,
    fetchingLogin,
    fetchingRegister,
    fetchingLogout,
    fetchingMe,
  } = useAuthService();
  const [error, setError] = useState('');
  const [errorsFields, setErrorsFields] = useState({});

  useEffect(() => {
    const token = getCookie('token');
  
    if (token) {
      checkAuth();
    } else {
      setLoading(false);
    }
  }, []);

  const checkAuth = async () => {
    try {
      me({
        onSuccess: (response) => {
          if (response.data) {
            setUser(response.data);
          }
        }
      });
    } catch (error) {
      console.error('Error checking auth:', error);
    } finally {
      setLoading(false);
    }
  };

  const login = async (email: string, password: string, remember_me: boolean) => {
    try {
      loginService(
        { email, password, remember_me },
        {
          onSuccess: (response) => {
            if (response.data) {
              setUser(response.data);
              setCookie('token', response.data.token);
              setCookie('rememberMe', remember_me);
              router.push('/intranet');
            }
          },
          onError: (response) => {
            setError(response.message);
          },
          onFieldError: (response) => {
            setErrorsFields(response.errors ?? {});
          }
        }
      );
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  };

  const logout = async () => {
    try {
      logoutService({
        onSuccess: () => {
          setUser(null);
          router.push('/login');
        }
      });
    } catch (error) {
      console.error('Logout error:', error);
      throw error;
    }
  };

  const register = async (name: string, email: string, password: string, password_confirmation: string) => {
    try {
      registerService(
        { name, email, password, password_confirmation },
        {
          onSuccess: (response) => {
            if (response.data) {
              setUser(response.data);
              router.push('/intranet');
            }
          },
          onError: (response) => {
            setError(response.message);
          },
          onFieldError: (response) => {
            setErrorsFields(response.errors ?? {});
          }
        }
      );
    } catch (error) {
      console.error('Register error:', error);
      throw error;
    }
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        isAuthenticated: !!user,
        login,
        logout,
        register,
        loading,
        fetchingLogin,
        fetchingRegister,
        fetchingLogout,
        fetchingMe,
        error,
        errorsFields,
        setErrorsFields
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
} 