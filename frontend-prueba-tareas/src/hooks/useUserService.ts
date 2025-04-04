import { useState } from 'react';
import useFetch from './useFetch';
import { ServiceEvents } from './interfaces';

export interface User {
  id: number;
  name: string;
}

const useUserService = () => {
  const { doGet } = useFetch();

  const [fetchingUsers, setFetchingUsers] = useState(false);

  const getUsersForTaskFilter = (events: ServiceEvents = {}) => {
    doGet({
      ...events,
      url: 'http://localhost:8000/api/user/for-task-filter',
      setFetching: setFetchingUsers
    });
  };

  return {
    fetchingUsers,
    getUsersForTaskFilter
  };
};

export default useUserService; 