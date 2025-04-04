'use client';

import { useState, useEffect } from 'react';
import { useAuth } from '@/context/AuthContext';
import { PlusIcon } from '@heroicons/react/24/outline';
import useTaskService from '@/hooks/useTaskService';
import TaskCounters from '@/components/TaskCounters';
import TaskColumn from '@/components/TaskColumn';
import UserFilter from '@/components/UserFilter';
import { Task } from '@/hooks/useTaskService';
import { ServiceResponse } from '@/hooks/interfaces';
import useUserService, { User } from '@/hooks/useUserService';
import TaskModal from './components/TaskModal';

const states = {
  pendiente: { label: 'Pendiente', color: 'bg-red-100 text-red-800' },
  en_progreso: { label: 'En Progreso', color: 'bg-yellow-100 text-yellow-800' },
  completada: { label: 'Completada', color: 'bg-green-100 text-green-800' }
};

export default function IntranetPage() {
  const { user } = useAuth();
  const [tasks, setTasks] = useState<Task[]>([]);
  const [filteredTasks, setFilteredTasks] = useState<Task[]>([]);
  const [allTasksCount, setAllTasksCount] = useState(0);
  const [userTasksCount, setUserTasksCount] = useState(0);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [currentTask, setCurrentTask] = useState<Task | null>(null);
  const [formData, setFormData] = useState<{
    title: string;
    description?: string;
    state: string;
  }>({
    title: '',
    state: 'pendiente'
  });
  const [selectedUserIds, setSelectedUserIds] = useState<number[]>([]);
  const [errors, setErrors] = useState<object>({});
  const {
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
  } = useTaskService();

  useEffect(() => {
    fetchData();
  }, []);

  const { fetchingUsers, getUsersForTaskFilter } = useUserService();
  const [users, setUsers] = useState<User[]>([]);

  useEffect(() => {
    if (selectedUserIds.length === 0) {
      setFilteredTasks(tasks);
    } else {
      setFilteredTasks(tasks.filter(task => selectedUserIds.includes(task.user_id)));
    }
  }, [tasks, selectedUserIds]);

  const fetchData = () => {
    getTasks({
      onSuccess: (response) => {
        if (Array.isArray(response.data)) {
          setTasks(response.data);
          setFilteredTasks(response.data);
        } else {
          setTasks([]);
          setFilteredTasks([]);
        }
      }
    });

    getUsersForTaskFilter({
      onSuccess: (response) => {
        if (Array.isArray(response.data)) {
          setUsers(response.data);
        }
      }
    });

    getStats({
      onSuccess: (response) => {
        if (response.data) {
          setAllTasksCount(response.data.total_tasks || 0);
          setUserTasksCount(response.data.user_tasks || 0);
        }
      }
    });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const taskData = {
      title: formData.title,
      description: formData.description,
      state: formData.state
    };

    if (currentTask) {
      updateTask(currentTask.id, taskData, {
        onSuccess: () => {
          setIsModalOpen(false);
          setCurrentTask(null);
          setFormData({ title: '', description: '', state: 'pendiente' });
          fetchData();
        },
        onError: (error) => {
          alert(error.message);
        }
      });
    } else {
      storeTask(taskData, {
        onSuccess: () => {
          setIsModalOpen(false);
          setFormData({ title: '', description: '', state: 'pendiente' });
          fetchData();
        },
        onError: (error) => {
          alert(error.message);
        },
        onFieldError(response: ServiceResponse) {
          setErrors(response.errors ?? {});
        },
      });
    }
  };

  const handleDelete = (taskId: number) => {
    if (window.confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
      deleteTask(taskId, {
        onSuccess: () => fetchData(),
        onError: (error) => {
          alert(error.message);
        }
      });
    }
  };

  const openEditModal = (task: Task) => {
    setCurrentTask(task);
    setFormData({
      title: task.title,
      description: task.description,
      state: task.state
    });
    setIsModalOpen(true);
  };

  const getTasksByState = (state: string) => {
    return filteredTasks.filter(task => task.state === state);
  };

  const handleUserFilterChange = (userIds: number[]) => {
    setSelectedUserIds(userIds);
  };

  return (
    <div className="space-y-6">
      <TaskCounters
        userTasksCount={userTasksCount}
        allTasksCount={allTasksCount}
        isLoading={fetchingGetStats}
      />

      <div className="card-base">
        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-semibold text-slate-800">Tablero de Tareas</h2>
          <button
            onClick={() => setIsModalOpen(true)}
            className="button-primary flex items-center gap-2"
            disabled={fetchingStoreTask}
          >
            <PlusIcon className="h-5 w-5" />
            {fetchingStoreTask ? 'Cargando...' : 'Nueva Tarea'}
          </button>
        </div>

        <UserFilter onFilterChange={handleUserFilterChange} users={users} fetchingUsers={fetchingUsers} />

        {fetchingGetTasks ? (
          <div className="flex justify-center items-center py-8">
            <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-800"></div>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {Object.entries(states).map(([state, { label, color }]) => (
              <TaskColumn
                key={state}
                state={state}
                label={label}
                color={color}
                tasks={getTasksByState(state)}
                onEdit={openEditModal}
                onDelete={handleDelete}
                isUpdating={fetchingUpdateTask}
                isDeleting={fetchingDeleteTask}
              />
            ))}
          </div>
        )}
      </div>

      <TaskModal
        isOpen={isModalOpen}
        onClose={() => {
          setIsModalOpen(false);
          setCurrentTask(null);
          setFormData({ title: '', description: '', state: 'pendiente' });
        }}
        onSubmit={handleSubmit}
        currentTask={currentTask}
        formData={formData}
        setFormData={setFormData}
        isSubmitting={currentTask ? fetchingUpdateTask : fetchingStoreTask}
        errors={errors}
        setErrors={setErrors}
      />
    </div>
  );
} 