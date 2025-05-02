-- Skema pangkalan data untuk sistem pengurusan besbol
-- Mengandungi semua jadual yang diperlukan dengan hubungan yang betul
-- Table: users 
CREATE TABLE users ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(100), 
    email VARCHAR(100) UNIQUE, 
    password VARCHAR(255), 
    role ENUM('admin', 'coach', 'player', 'umpire'), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
); 

-- Table: teams 
CREATE TABLE teams ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(100), 
    short_name VARCHAR(10), 
    logo VARCHAR(255), 
    location VARCHAR(100), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
); 

-- Table: seasons 
CREATE TABLE seasons ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    year INT, 
    name VARCHAR(100), 
    start_date DATE, 
    end_date DATE, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
); 

-- Table: leagues 
CREATE TABLE leagues ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(100), 
    level VARCHAR(50), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
); 

-- Table: league_season_team 
CREATE TABLE league_season_team ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    league_id BIGINT, 
    season_id BIGINT, 
    team_id BIGINT, 
    FOREIGN KEY (league_id) REFERENCES leagues(id), 
    FOREIGN KEY (season_id) REFERENCES seasons(id), 
    FOREIGN KEY (team_id) REFERENCES teams(id) 
); 

-- Table: players 
CREATE TABLE players ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    user_id BIGINT, 
    team_id BIGINT, 
    jersey_number INT, 
    position VARCHAR(50), 
    batting_hand ENUM('left', 'right', 'switch'), 
    throwing_hand ENUM('left', 'right'), 
    birthdate DATE, 
    nationality VARCHAR(50), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (user_id) REFERENCES users(id), 
    FOREIGN KEY (team_id) REFERENCES teams(id) 
); 

-- Table: games 
CREATE TABLE games ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    season_id BIGINT, 
    league_id BIGINT, 
    home_team_id BIGINT, 
    away_team_id BIGINT, 
    game_date DATETIME, 
    venue VARCHAR(100), 
    status ENUM('scheduled', 'in_progress', 'completed', 'postponed'), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (season_id) REFERENCES seasons(id), 
    FOREIGN KEY (league_id) REFERENCES leagues(id), 
    FOREIGN KEY (home_team_id) REFERENCES teams(id), 
    FOREIGN KEY (away_team_id) REFERENCES teams(id) 
); 

-- Table: game_stats 
CREATE TABLE game_stats ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    game_id BIGINT, 
    home_team_runs INT, 
    away_team_runs INT, 
    inning_count INT, 
    winner_team_id BIGINT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (game_id) REFERENCES games(id), 
    FOREIGN KEY (winner_team_id) REFERENCES teams(id) 
); 

-- Table: player_game_stats 
CREATE TABLE player_game_stats ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    player_id BIGINT, 
    game_id BIGINT, 
    at_bats INT, 
    hits INT, 
    runs INT, 
    rbi INT, 
    walks INT, 
    strikeouts INT, 
    home_runs INT, 
    stolen_bases INT, 
    innings_pitched DECIMAL(4,1), 
    earned_runs INT, 
    pitch_count INT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (player_id) REFERENCES players(id), 
    FOREIGN KEY (game_id) REFERENCES games(id) 
); 

-- Table: positions 
CREATE TABLE positions ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(50), 
    abbreviation VARCHAR(10) 
); 

-- Table: player_positions 
CREATE TABLE player_positions ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    player_id BIGINT, 
    game_id BIGINT, 
    position_id BIGINT, 
    FOREIGN KEY (player_id) REFERENCES players(id), 
    FOREIGN KEY (game_id) REFERENCES games(id), 
    FOREIGN KEY (position_id) REFERENCES positions(id) 
); 

-- Table: umpires 
CREATE TABLE umpires ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    user_id BIGINT, 
    certification_level VARCHAR(50), 
    experience_years INT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (user_id) REFERENCES users(id) 
); 

-- Table: game_umpires 
CREATE TABLE game_umpires ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    game_id BIGINT, 
    umpire_id BIGINT, 
    role VARCHAR(50), 
    FOREIGN KEY (game_id) REFERENCES games(id), 
    FOREIGN KEY (umpire_id) REFERENCES umpires(id) 
); 

-- Table: events 
CREATE TABLE events ( 
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    game_id BIGINT, 
    inning INT, 
    half ENUM('top', 'bottom'), 
    description TEXT, 
    player_id BIGINT, 
    event_type VARCHAR(50), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (game_id) REFERENCES games(id), 
    FOREIGN KEY (player_id) REFERENCES players(id) 
);