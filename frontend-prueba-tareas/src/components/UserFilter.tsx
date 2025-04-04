import { useState, useEffect } from 'react';
import useUserService from '@/hooks/useUserService';
import { User } from '@/hooks/useUserService';
import UserAvatar from './UserAvatar';

interface UserFilterProps {
  onFilterChange: (selectedUserIds: number[]) => void;
  users: User[];
  fetchingUsers: boolean;

}

export default function UserFilter({ onFilterChange, users, fetchingUsers }: UserFilterProps) {

  const [selectedUsers, setSelectedUsers] = useState<number[]>([]);


  const handleUserClick = (userId: number) => {
    const newSelectedUsers = selectedUsers.includes(userId)
      ? selectedUsers.filter(id => id !== userId)
      : [...selectedUsers, userId];
    
    setSelectedUsers(newSelectedUsers);
    onFilterChange(newSelectedUsers);
  };

  return (
    <div className="mb-6">
      <h3 className="text-lg font-semibold text-slate-700 mb-3">Filtrar por Usuario</h3>
      {fetchingUsers ? (
        <div className="flex justify-center">
          <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-slate-800"></div>
        </div>
      ) : (
        <div className="flex flex-wrap gap-2">
          {users.map(user => (
            <button
              key={user.id}
              onClick={() => handleUserClick(user.id)}
              className={`rounded-full transition-transform hover:scale-110 focus:outline-none ${
                selectedUsers.includes(user.id) ? 'ring-2 ring-offset-2 ring-slate-800 rounded-full' : ''
              }`}
              title={user.name}
            >
              <UserAvatar userId={user.id} name={user.name} size="md" />
            </button>
          ))}
        </div>
      )}
    </div>
  );
} 