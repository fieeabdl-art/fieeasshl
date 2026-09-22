package com.example.bumiyuji.ui.viewmodel

import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import com.example.bumiyuji.data.repository.AuthRepository
import com.example.bumiyuji.data.repository.HeroRepository
import com.example.bumiyuji.data.repository.PortfolioRepository
import com.example.bumiyuji.data.repository.ProjectRepository
import com.example.bumiyuji.data.repository.PublicRepository
import com.example.bumiyuji.data.repository.ServiceRepository
import com.example.bumiyuji.data.repository.SettingRepository
import com.example.bumiyuji.data.repository.TeamRepository

class ViewModelFactory(
    private val authRepository: AuthRepository,
    private val portfolioRepository: PortfolioRepository,
    private val publicRepository: PublicRepository,
    private val heroRepository: HeroRepository,
    private val serviceRepository: ServiceRepository,
    private val teamRepository: TeamRepository,
    private val settingRepository: SettingRepository,
    private val projectRepository: ProjectRepository
) : ViewModelProvider.Factory {

    @Suppress("UNCHECKED_CAST")
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        return when {
            modelClass.isAssignableFrom(LoginViewModel::class.java) -> {
                LoginViewModel(authRepository) as T
            }
            modelClass.isAssignableFrom(PortfolioViewModel::class.java) -> {
                PortfolioViewModel(portfolioRepository) as T
            }
            modelClass.isAssignableFrom(HomeViewModel::class.java) -> {
                HomeViewModel(publicRepository) as T
            }
            modelClass.isAssignableFrom(HeroViewModel::class.java) -> {
                HeroViewModel(heroRepository) as T
            }
            modelClass.isAssignableFrom(ServiceViewModel::class.java) -> {
                ServiceViewModel(serviceRepository) as T
            }
            modelClass.isAssignableFrom(TeamViewModel::class.java) -> {
                TeamViewModel(teamRepository) as T
            }
            modelClass.isAssignableFrom(SettingViewModel::class.java) -> {
                SettingViewModel(settingRepository) as T
            }
            modelClass.isAssignableFrom(ProjectViewModel::class.java) -> {
                ProjectViewModel(projectRepository) as T
            }
            else -> throw IllegalArgumentException("Unknown ViewModel class")
        }
    }
}
