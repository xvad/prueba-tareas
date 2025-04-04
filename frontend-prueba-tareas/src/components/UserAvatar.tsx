interface UserAvatarProps {
  userId: number;
  name: string;
  size?: 'sm' | 'md' | 'lg';
}

const getColorFromId = (id: number) => {
  // Genera un color basado en el ID usando HSL
  const hue = (id * 137.508) % 360; // Usa el ángulo dorado para distribuir los colores
  return `hsl(${hue}, 70%, 50%)`;
};

export default function UserAvatar({ userId, name, size = 'md' }: UserAvatarProps) {
  const sizeClasses = {
    sm: 'w-6 h-6 text-xs',
    md: 'w-8 h-8 text-sm',
    lg: 'w-10 h-10 text-base'
  };

  return (
    <div
      className={`flex items-center justify-center rounded-full text-white font-semibold ${sizeClasses[size]}`}
      style={{ backgroundColor: getColorFromId(userId) }}
      title={name}
    >
      {name.charAt(0).toUpperCase()}
    </div>
  );
} 