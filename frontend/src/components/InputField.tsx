import { InputAdornment, TextField } from "@mui/material";
import React from "react"

type InputFieldProps = {
  type: string;
  label: string;
  value: unknown;
  onChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
  maxLength?: number;
  minLength?: number;
  isCurrency?: boolean;
  style?: React.CSSProperties;
};

const InputField = ({
  type,
  label,
  value,
  onChange,
  maxLength = 100,
  minLength = 1,
  isCurrency = false,
  style = {}
}: InputFieldProps) => {
  return (
    <TextField
      
      label={label}
      type={type}
      value={value}
      onChange={onChange}
      InputProps={{
        startAdornment: isCurrency ? (
          <InputAdornment position="start">R$</InputAdornment>
        ) : null,
      }}
      inputProps={{
        maxLength,
        minLength,
      }}
      sx={{width: 500, marginTop: 1.5, ...style}}
    />
  );
};

export { InputField };
