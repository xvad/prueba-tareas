import { useState } from 'react';
import useFetch from './useFetch';
import { ServiceEvents } from './interfaces';

export interface User {
  id: number;
  name: string;
  email: string;
}

export interface Task {
  id: number;
  title: string;
  description?: string;
  state: string;
  user_id: number;
  created_at: string;
  updated_at: string;
  user?: User;
}

const useTaskService = () => {
  const { doGet, doPost, doPut, doDelete } = useFetch();

  const [fetchingGetTasks, setFetchingGetTasks] = useState(false);
  const [fetchingGetStats, setFetchingGetStats] = useState(false);
  const [fetchingStoreTask, setFetchingStoreTask] = useState(false);
  const [fetchingUpdateTask, setFetchingUpdateTask] = useState(false);
  const [fetchingDeleteTask, setFetchingDeleteTask] = useState(false);

  const getTasks = (events: ServiceEvents = {}) => {
    doGet({
      ...events,
      url: 'http://localhost:8000/api/task',
      setFetching: setFetchingGetTasks
    });
  };

  const getStats = (events: ServiceEvents = {}) => {
    doGet({
      ...events,
      url: 'http://localhost:8000/api/task/stats',
      setFetching: setFetchingGetStats
    });
  };

  const storeTask = (task: Omit<Task, 'id' | 'created_at' | 'updated_at' | 'user_id'>, events: ServiceEvents = {}) => {
    doPost({
      ...events,
      url: 'http://localhost:8000/api/task/store',
      body: task,
      setFetching: setFetchingStoreTask
    });
  };

  const updateTask = (id: number, task: Partial<Task>, events: ServiceEvents = {}) => {
    doPut({
      ...events,
      url: `http://localhost:8000/api/task/${id}/update`,
      body: task,
      setFetching: setFetchingUpdateTask
    });
  };

  const deleteTask = (id: number, events: ServiceEvents = {}) => {
    doDelete({
      ...events,
      url: `http://localhost:8000/api/task/${id}/delete`,
      setFetching: setFetchingDeleteTask
    });
  };

  return {
    fetchingGetTasks,
    fetchingGetStats,
    fetchingStoreTask,
    fetchingUpdateTask,
    fetchingDeleteTask,
    getTasks,
    getStats,
    storeTask,
    updateTask,
    deleteTask
  };
};

export default useTaskService; 