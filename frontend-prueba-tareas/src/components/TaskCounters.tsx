interface TaskCountersProps {
  userTasksCount: number;
  allTasksCount: number;
  isLoading: boolean;
}

export default function TaskCounters({
  userTasksCount,
  allTasksCount,
  isLoading
}: TaskCountersProps) {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div className="card-base">
        <h3 className="text-lg font-semibold text-slate-700">Mis Tareas</h3>
        {isLoading ? (
          <div className="flex justify-center items-center py-4">
            <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-slate-800"></div>
          </div>
        ) : (
          <p className="text-3xl font-bold text-slate-800">{userTasksCount}</p>
        )}
      </div>
      <div className="card-base">
        <h3 className="text-lg font-semibold text-slate-700">Total Tareas</h3>
        {isLoading ? (
          <div className="flex justify-center items-center py-4">
            <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-slate-800"></div>
          </div>
        ) : (
          <p className="text-3xl font-bold text-slate-800">{allTasksCount}</p>
        )}
      </div>
    </div>
  );
} 