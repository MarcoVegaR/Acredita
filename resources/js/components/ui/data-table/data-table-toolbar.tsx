import { X } from "lucide-react";
import { Table } from "@tanstack/react-table";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

interface DataTableToolbarProps<TData> {
  table: Table<TData>;
  searchColumn?: string;
  searchPlaceholder?: string;
  filterableColumns?: {
    id: string;
    title: string;
    options: {
      value: string;
      label: string;
    }[];
  }[];
  onSearch?: (value: string) => void;
}

export function DataTableToolbar<TData>({
  table,
  searchColumn,
  searchPlaceholder = "Buscar...",
  onSearch,
}: DataTableToolbarProps<TData>) {
  const isFiltered =
    table.getState().columnFilters.length > 0 || !!table.getState().globalFilter;

  return (
    <div className="flex items-center justify-between mb-4">
      <div className="flex flex-1 items-center space-x-2">
        {searchColumn && (
          <Input
            placeholder={searchPlaceholder}
            value={table.getState().globalFilter ?? ""}
            onChange={(event) => {
              const value = event.target.value;
              table.setGlobalFilter(value);
              onSearch?.(value);
            }}
            className="h-9 w-[250px]"
          />
        )}
        {isFiltered && (
          <Button
            variant="ghost"
            onClick={() => {
              table.resetColumnFilters();
              table.resetGlobalFilter();
              if (onSearch) onSearch("");
            }}
            className="h-9 px-2 lg:px-3"
          >
            Limpiar
            <X className="ml-2 h-4 w-4" />
          </Button>
        )}
      </div>
      <div className="flex flex-1 items-center justify-end space-x-2">
        {/* Aquí se pueden añadir botones adicionales para acciones como exportar, etc. */}
      </div>
    </div>
  );
}
