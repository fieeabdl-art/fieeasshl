package com.example.bumiyuji

import android.app.Application
import com.example.bumiyuji.data.api.RetrofitClient
import com.example.bumiyuji.data.local.SessionManager
import com.example.bumiyuji.data.repository.AuthRepository
import com.example.bumiyuji.data.repository.HeroRepository
import com.example.bumiyuji.data.repository.PortfolioRepository
import com.example.bumiyuji.data.repository.ProjectRepository
import com.example.bumiyuji.data.repository.PublicRepository
import com.example.bumiyuji.data.repository.ServiceRepository
import com.example.bumiyuji.data.repository.SettingRepository
import com.example.bumiyuji.data.repository.TeamRepository

class BumiyujiApplication : Application() {

    lateinit var sessionManager: SessionManager
    lateinit var authRepository: AuthRepository
    lateinit var portfolioRepository: PortfolioRepository
    lateinit var publicRepository: PublicRepository
    lateinit var heroRepository: HeroRepository
    lateinit var serviceRepository: ServiceRepository
    lateinit var teamRepository: TeamRepository
    lateinit var settingRepository: SettingRepository
    lateinit var projectRepository: ProjectRepository

    override fun onCreate() {
        super.onCreate()
        sessionManager = SessionManager(this)
        val apiService = RetrofitClient.getApiService(this)
        authRepository = AuthRepository(apiService, sessionManager)
        portfolioRepository = PortfolioRepository(apiService)
        publicRepository = PublicRepository(apiService)
        heroRepository = HeroRepository(apiService)
        serviceRepository = ServiceRepository(apiService)
        teamRepository = TeamRepository(apiService)
        settingRepository = SettingRepository(apiService)
        projectRepository = ProjectRepository(apiService)
    }
}
