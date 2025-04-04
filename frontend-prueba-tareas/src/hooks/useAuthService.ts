import { useState } from 'react';
import useFetch from './useFetch';
import { ServiceEvents } from './interfaces';

interface User {
  id: number;
  name: string;
  email: string;
}

const useAuthService = () => {
  const { doGet, doPost } = useFetch();

  const [fetchingLogin, setFetchingLogin] = useState(false);
  const [fetchingRegister, setFetchingRegister] = useState(false);
  const [fetchingLogout, setFetchingLogout] = useState(false);
  const [fetchingMe, setFetchingMe] = useState(false);

  const login = (data: { email: string; password: string; remember_me: boolean }, events: ServiceEvents = {}) => {
    doPost({
      ...events,
      url: 'http://localhost:8000/api/auth/login',
      body: data,
      setFetching: setFetchingLogin
    });
  };

  const register = (data: { name: string; email: string; password: string; password_confirmation: string }, events: ServiceEvents = {}) => {
    doPost({
      ...events,
      url: 'http://localhost:8000/api/auth/register',
      body: data,
      setFetching: setFetchingRegister
    });
  };

  const logout = (events: ServiceEvents = {}) => {
    doPost({
      ...events,
      url: 'http://localhost:8000/api/auth/logout',
      setFetching: setFetchingLogout
    });
  };

  const me = (events: ServiceEvents = {}) => {
    doGet({
      ...events,
      url: 'http://localhost:8000/api/auth/me',
      setFetching: setFetchingMe
    });
  };

  return {
    fetchingLogin,
    fetchingRegister,
    fetchingLogout,
    fetchingMe,
    login,
    register,
    logout,
    me
  };
};

export default useAuthService; 