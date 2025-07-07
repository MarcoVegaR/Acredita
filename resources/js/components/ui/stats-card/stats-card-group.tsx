import { cn } from "@/lib/utils";
import React from "react";

type StatsCardGroupProps = {
  children: React.ReactNode;
  className?: string;
  layout?: "grid" | "row";
  columns?: 2 | 3 | 4 | 5;
};

export function StatsCardGroup({
  children,
  className,
  layout = "grid",
  columns = 4,
}: StatsCardGroupProps) {
  // Map number of columns to Tailwind CSS class
  const columnsClass = {
    2: "grid-cols-1 sm:grid-cols-2",
    3: "grid-cols-1 sm:grid-cols-2 lg:grid-cols-3",
    4: "grid-cols-1 sm:grid-cols-2 lg:grid-cols-4",
    5: "grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5",
  };

  return (
    <div
      className={cn(
        layout === "grid"
          ? `grid gap-4 ${columnsClass[columns]}`
          : "flex flex-col sm:flex-row gap-4",
        className
      )}
    >
      {children}
    </div>
  );
}
