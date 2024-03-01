import { InputLabel, MenuItem, Select, SelectChangeEvent } from "@mui/material";
import { Option } from "../store/usePayment/types";
import React from "react"

type SelectFieldProps = {
  label: string;
  value: string | undefined;
  options: Option[];
  onChange: (event: SelectChangeEvent) => void;
  style?: React.CSSProperties;
};

const SelectField = ({ label, value, options, onChange, style }: SelectFieldProps) => {
  const handleChange = (event: SelectChangeEvent) => {
    onChange(event);
  };

  return (
    <>
      <InputLabel id="select-field" sx={{marginTop: 1}}>{label}</InputLabel>
      <Select
        displayEmpty
        labelId="select-field"
        value={value}
        onChange={handleChange}
        sx={{width: 500, ...style}}
      >
        <MenuItem disabled value="">
          Selecione
        </MenuItem>
        {options.map((option) => (
          <MenuItem key={option.value} value={option.value}>
            {option.label}
          </MenuItem>
        ))}
      </Select>
    </>
  );
};

export { SelectField };
