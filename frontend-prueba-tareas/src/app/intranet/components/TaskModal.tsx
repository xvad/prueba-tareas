import useHandleErrorFields from '@/hooks/useHandleErrorFields';
import { Task } from '@/hooks/useTaskService';
import { useEffect } from 'react';

interface TaskModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSubmit: (e: React.FormEvent) => void;
  currentTask: Task | null;
  formData: {
    title: string;
    description?: string;
    state: string;
  };
  setFormData: (data: { title: string; description?: string; state: string }) => void;
  isSubmitting: boolean;
  errors?: object;
  setErrors?: (errors: object) => void;
}

const states = {
  pendiente: { label: 'Pendiente', color: 'bg-red-100 text-red-800' },
  en_progreso: { label: 'En Progreso', color: 'bg-yellow-100 text-yellow-800' },
  completada: { label: 'Completada', color: 'bg-green-100 text-green-800' }
};

export default function TaskModal({
  isOpen,
  onClose,
  onSubmit,
  currentTask,
  formData,
  setFormData,
  isSubmitting,
  errors,
  setErrors
}: TaskModalProps) {
  if (!isOpen) return null;
  const { fieldErrorMessage, fieldHasError, onFocusRemove } = useHandleErrorFields();
  

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div className="bg-white rounded-lg p-6 max-w-md w-full">
        <h2 className="text-2xl font-semibold text-slate-800 mb-4">
          {currentTask ? 'Editar Tarea' : 'Nueva Tarea'}
        </h2>
        <form onSubmit={onSubmit} className="space-y-4">
          <div>
            <label className="label-base">Título (*)</label>
            <input
              type="text"
              value={formData.title}
              onChange={(e) => setFormData({ ...formData, title: e.target.value })}
              className={`input-base ${fieldHasError('title', errors) ? 'border-red-500' : ''}`}
              disabled={isSubmitting}
              onFocus={() => setErrors && onFocusRemove('title', errors, setErrors)}
            />
          </div>
          <div className={`error-field ${fieldHasError('title', errors) ? 'block' : 'hidden'}`}>
            {fieldErrorMessage('title', errors)}
          </div>
          <div>
            <label className="label-base">Descripción</label>
            <textarea
              value={formData.description}
              onChange={(e) => setFormData({ ...formData, description: e.target.value })}
              className="input-base"
              rows={3}
              disabled={isSubmitting}
            />
          </div>
          <div>
            <label className="label-base">Estado (*)</label>
            <select
              value={formData.state}
              onChange={(e) => setFormData({ ...formData, state: e.target.value })}
              className="input-base"
              disabled={isSubmitting}
            >
              {Object.entries(states).map(([value, { label }]) => (
                <option key={value} value={value}>{label}</option>
              ))}
            </select>
          </div>
          <div className="flex justify-end space-x-4">
            <button
              type="button"
              onClick={onClose}
              className="px-4 py-2 text-slate-600 hover:text-slate-800 disabled:opacity-50"
              disabled={isSubmitting}
            >
              Cancelar
            </button>
            <button
              type="submit"
              className="button-primary disabled:opacity-50"
              disabled={isSubmitting}
            >
              {isSubmitting ? (
                <div className="flex items-center gap-2">
                  <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                  {currentTask ? 'Actualizando...' : 'Creando...'}
                </div>
              ) : (
                currentTask ? 'Actualizar' : 'Crear'
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
} 