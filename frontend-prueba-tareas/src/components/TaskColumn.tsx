import { Task } from '@/hooks/useTaskService';
import { PencilIcon, TrashIcon } from '@heroicons/react/24/outline';
import UserAvatar from './UserAvatar';

interface TaskColumnProps {
  state: string;
  label: string;
  color: string;
  tasks: Task[];
  onEdit: (task: Task) => void;
  onDelete: (taskId: number) => void;
  isUpdating: boolean;
  isDeleting: boolean;
}

export default function TaskColumn({
  state,
  label,
  color,
  tasks,
  onEdit,
  onDelete,
  isUpdating,
  isDeleting
}: TaskColumnProps) {
  return (
    <div className="bg-slate-50 rounded-lg p-4">
      <div className="flex justify-between items-center mb-4">
        <h3 className="text-lg font-semibold text-slate-700">{label}</h3>
        <span className={`px-3 py-1 rounded-full text-sm font-medium ${color}`}>
          {tasks.length}
        </span>
      </div>
      <div className="space-y-4">
        {tasks.map(task => (
          <div
            key={task.id}
            className="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow cursor-pointer relative"
            onClick={() => onEdit(task)}
          >
            <div className="flex justify-between items-start">
              <h4 className="font-medium text-slate-800">{task.title}</h4>
              <div className="flex space-x-2">
                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    onEdit(task);
                  }}
                  className="text-blue-600 hover:text-blue-900 disabled:opacity-50"
                  disabled={isUpdating}
                >
                  <PencilIcon className="h-4 w-4" />
                </button>
                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    onDelete(task.id);
                  }}
                  className="text-red-600 hover:text-red-900 disabled:opacity-50"
                  disabled={isDeleting}
                >
                  <TrashIcon className="h-4 w-4" />
                </button>
              </div>
            </div>
            <p className="text-sm text-slate-600 mt-2 line-clamp-2">{task.description}</p>
            <div className="mt-3 text-xs text-slate-500">
              Actualizado: {new Date(task.updated_at).toLocaleDateString()}
            </div>
            <div className="absolute bottom-2 right-2">
              <UserAvatar userId={task.user_id} name={task.user!.name} size="sm" />
            </div>
          </div>
        ))}
        {tasks.length === 0 && (
          <div className="text-center text-slate-500 py-4">
            No hay tareas en este estado
          </div>
        )}
      </div>
    </div>
  );
} 