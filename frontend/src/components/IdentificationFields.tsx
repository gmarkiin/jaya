import { FormControl, TextField, MenuItem, InputLabel} from '@mui/material'
import Select, { SelectChangeEvent } from '@mui/material/Select';
import * as React from 'react';

export const IdentificationFields = () => {
    const [identification, setIdentification] = React.useState('');

    const handleChange = (event: SelectChangeEvent) => {
        setIdentification(event.target.value);
    };
    return (
        <FormControl sx={{ minWidth: 370 }} size="small">
            <InputLabel sx={{ marginTop: 2 }}>Tipo de identificação</InputLabel>
            <Select  
                sx={{ marginTop: 3 }}
                value={identification}
                onChange={handleChange}
            >
                <MenuItem value={'cpf'}>CPF</MenuItem>
                <MenuItem value={'cnpj'}>CNPJ</MenuItem>
            </Select>
            <TextField sx={{ marginTop: 3 }} label='Número de identificação' />
        </FormControl>
    )
}