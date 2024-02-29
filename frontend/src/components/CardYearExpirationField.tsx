import { Stack, TextField } from '@mui/material'

export const CardYearExpirationField = () => {
    return (
        <Stack sx={{marginTop: 2}}>
            <Stack direction={'row'} spacing={202}>
                <TextField label='Ano de expiracao (YYYY)' />
            </Stack>
        </Stack>
    )
}