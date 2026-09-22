package com.example.bumiyuji.data.local

import android.content.Context
import androidx.datastore.core.DataStore
import androidx.datastore.preferences.core.Preferences
import androidx.datastore.preferences.core.edit
import androidx.datastore.preferences.core.stringPreferencesKey
import androidx.datastore.preferences.preferencesDataStore
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.MutableSharedFlow
import kotlinx.coroutines.flow.asSharedFlow
import kotlinx.coroutines.flow.map

private val Context.dataStore: DataStore<Preferences> by preferencesDataStore(name = "session_prefs")

class SessionManager(private val context: Context) {

    private val _sessionExpiredEvent = MutableSharedFlow<Boolean>()
    val sessionExpiredEvent = _sessionExpiredEvent.asSharedFlow()

    companion object {
        private val TOKEN_KEY = stringPreferencesKey("auth_token")
        private val ADMIN_NAME_KEY = stringPreferencesKey("admin_name")
        private val ADMIN_ROLE_KEY = stringPreferencesKey("admin_role")
    }

    val authToken: Flow<String?> = context.dataStore.data.map { preferences ->
        preferences[TOKEN_KEY]
    }

    suspend fun saveAuthToken(token: String) {
        context.dataStore.edit { preferences ->
            preferences[TOKEN_KEY] = token
        }
    }

    suspend fun saveAdminInfo(name: String, role: String) {
        context.dataStore.edit { preferences ->
            preferences[ADMIN_NAME_KEY] = name
            preferences[ADMIN_ROLE_KEY] = role
        }
    }

    suspend fun clearSession() {
        context.dataStore.edit { preferences ->
            preferences.remove(TOKEN_KEY)
            preferences.remove(ADMIN_NAME_KEY)
            preferences.remove(ADMIN_ROLE_KEY)
        }
    }

    suspend fun triggerSessionExpired() {
        clearSession()
        _sessionExpiredEvent.emit(true)
    }
}
